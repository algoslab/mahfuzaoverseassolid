<?php

namespace App\Http\Controllers\Supper_Admin\service;

use App\Http\Controllers\Controller;
use App\Models\Supper_Admin\service\AirTicket;
use App\Models\Supper_admin\service\AirTicketFile;
use Illuminate\Http\Request;

class AirTicketcontroller extends Controller
{

    public function index()
    {
        $airticketfile = AirTicketFile::get();
        return view('supper_admin.pages.service.airticket', compact('airticketfile'));
    }

    public function Activeindex(Request $request)
    {
        $start = $request->input('start', 0);  
        $length = $request->input('length', 10);  
        $searchValue = $request->input('search.value'); 
        // Query for active tickets
        $query = AirTicket::where('status', 1);
        // Apply search filter if present
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('destination_from', 'like', "%{$searchValue}%")
                  ->orWhere('destination_to', 'like', "%{$searchValue}%")
                  ->orWhere('flight_date', 'like', "%{$searchValue}%")
                  ->orWhere('full_airport_name', 'like', "%{$searchValue}%")
                  ->orWhere('airlines', 'like', "%{$searchValue}%");
            });
        }
        
        $totalRecords = AirTicket::where('status', 1)->count();
        $filteredRecords = $query->count();
        // Get paginated data
        $tickets = $query->skip($start)
                         ->take($length)
                         ->orderBy('flight_date', 'asc')
                         ->get();
        
        // Return JSON response
        return response()->json([
            'draw' => intval($request->input('draw')),  
            'recordsTotal' => $totalRecords,  
            'recordsFiltered' => $filteredRecords,  
            'data' => $tickets,  
        ]);
    }
    

    public function getDestinations()
    {
        $fromLocations = AirTicket::distinct()->pluck('destination_from');
        $toLocationsWithNames = AirTicket::select('destination_to', 'full_airport_name')
            ->distinct()
            ->get()
            ->map(function ($airport) {
                return [
                    'code' => $airport->destination_to,
                    'full_name' => "{$airport->destination_to} ({$airport->full_airport_name})",
                ];
            })
            ->unique('code')
            ->values(); 

        return response()->json([
            'from_locations' => $fromLocations,
            'to_locations' => $toLocationsWithNames,
        ]);

    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

 
    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }

 
    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        $upload = AirTicketFile::findOrFail($id);
        AirTicket::where('air_ticket_file_id', $id)->delete();
        $upload->delete();
        return back()->with('success', 'File and all related data deleted successfully.');
    }


    public function importCSV(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:3048',
        ]);

        $file = $request->file('csv_file');
        $fileName = $file->getClientOriginalName();
        $upload = AirTicketFile::create([
            'file_name'     => $fileName,
            'upload_date'   => now(),
        ]);

        if (($handle = fopen($file->getPathname(), "r")) !== false) {
            $header = fgetcsv($handle); 

            while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                if (count($row) < 12) { 
                    continue;
                }
                try {
                    try {
                        $flight_date = \Carbon\Carbon::createFromFormat('d-M-y', $row[2])->format('Y-m-d');
                    } catch (\Exception $e) {
                        try {
                            $flight_date = \Carbon\Carbon::createFromFormat('d/m/Y', $row[2])->format('Y-m-d');
                        } catch (\Exception $e) {
                            $flight_date = null; // Skip if format is unknown
                        }
                    }

                    AirTicket::create([
                        'air_ticket_file_id'=> $upload->id,
                        'destination_from'  => trim($row[0]),
                        'destination_to'    => trim($row[1]),
                        'flight_date'       => $flight_date,
                        'transit_time'      => trim($row[3]),
                        'luggage'           => trim($row[4]),
                        'food'              => trim($row[5]),
                        'b2b_fare'          => trim($row[6]),
                        'b2c_fare'          => trim($row[7]),
                        'group'             => trim($row[8]),
                        'full_airport_name' => trim($row[9]),
                        'airlines'          => trim($row[10]),
                        'status'            => trim($row[11])
                    ]);
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Error inserting row: ' . $e->getMessage()], 500);
                }
            }
            fclose($handle);
        }

        return back()->with('success', 'CSV Imported Successfully!');
    }


    

    public function downloadTemplate()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=sample_air_ticket.csv",
            "Pragma"              => "no-cache",
            "Expires"             => "0"
        ];
    
        // Define CSV Column Headers
        $columns = [
            'destination_from', 
            'destination_to', 
            'flight_date', 
            'transit_time', 
            'luggage',
            'food',
            'b2b_fare',
            'b2c_fare',
            'group',
            'full_airport_name',
            'airlines',
            'status',
        ];
    
        // Add Sample Data Row
        $sampleData = [
            ['New York', 'London', '2025-04-15', '2h 30m', '30kg', 'Yes', '500', '550', 'Corporate', 'John F. Kennedy International Airport', 'Bangladesh Biman', '1'],
            ['Dubai', 'Bangkok', '2025-06-10', 'No Transit', '20kg', 'No', '450', '500', 'Tour', 'Dubai International Airport', 'Bangladesh Biman', '0'],
        ];
    
        // Generate CSV File
        $callback = function() use ($columns, $sampleData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); 
    
            foreach ($sampleData as $row) {
                fputcsv($file, $row); // Add sample data rows
            }
    
            fclose($file);
        };
    
        return response()->stream($callback, 200, $headers);
    }
    

}
