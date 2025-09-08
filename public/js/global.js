
//global countires api--------


function fetchCountriess(selectId = '#countriesSelect') {
    $.ajax({
        url: window.routes.countryActive,
        method: "GET",
        success: function(data) {
            let select = $(selectId);
            select.empty();
            select.append('<option value="" disabled>Select a country</option>');

            let selectedCountryId = null;

            data.forEach(function(country) {
                // Check for "Bangladesh" (case-insensitive)
                if (country.name.toLowerCase() === 'bangladesh') {
                    selectedCountryId = country.id;
                }

                select.append(`<option value="${country.id}">${country.name}</option>`);
            });

            // Set Bangladesh as selected if found
            if (selectedCountryId !== null) {
                select.val(selectedCountryId);
            }
        },
        error: function(xhr) {
            console.error("Failed to fetch countries:", xhr);
        }
    });
}

function fetchDatacountriess(selectId = '#countriesSelect') {
    $.ajax({
        url: window.routes.countryActive,
        method: "GET",
        success: function(data) {
            let select = $(selectId);
            select.empty();
            // select.append('<option value="" disabled selected>Select a country</option>');
            data.forEach(function(country) {
                select.append(`<option value="${country.id}">${country.name}</option>`);
            });
        },
        error: function(xhr) {
            console.error("Failed to fetch division:", xhr);
        }
    });
}


function fetchDivisions(selectId = '#divisionsSelect') {
    $.ajax({
        url: window.routes.divisionActive,
        method: "GET",
        success: function(data) {
            let select = $(selectId);
            select.empty();
            select.append('<option value="" disabled selected>Select a Division</option>');
            data.forEach(function(division) {
                select.append(`<option value="${division.id}">${division.name}</option>`);
            });
        },
        error: function(xhr) {
            console.error("Failed to fetch division:", xhr);
        }
    });
}


function fetchDistricts(selectId = '#districtsSelect') {
    $.ajax({
        url: window.routes.districtActive,
        method: "GET",
        success: function(data) {
            let select = $(selectId);
            select.empty();
            select.append('<option value="" disabled selected>Select a district</option>');

            districtMap = {}; // Reset the map

            data.forEach(function(district) {
                districtMap[district.id] = district; // Save full district object
                select.append(`<option value="${district.id}">${district.name}</option>`);
            });
        },
        error: function(xhr) {
            console.error("Failed to fetch district:", xhr);
        }
    });
}


function fetchThanas(selectId = '#thanasSelect') {
    $.ajax({
        url: window.routes.thanaActive,
        method: "GET",
        success: function(data) {
            let select = $(selectId);
            select.empty();
            select.append('<option value="" disabled selected>Select a thana</option>');
            data.forEach(function(thana) {
                select.append(`<option value="${thana.id}">${thana.name}</option>`);
            });
        },
        error: function(xhr) {
            console.error("Failed to fetch thana:", xhr);
        }
    });
}

function fetchEmployees(selectId = '#employeesSelect') {
    $.ajax({
        url: window.routes.employeeActive,
        method: "GET",
        success: function(data) {
            let select = $(selectId);
            select.empty();
            select.append('<option value="" disabled selected>Select a employee</option>');
            data.forEach(function(employee) {
                select.append(`<option value="${employee.id}">${employee.first_name} ${employee.last_name} (${employee.branch.name})</option>`);
            });
        },
        error: function(xhr) {
            console.error("Failed to fetch employee:", xhr);
        }
    });
}

function fetchAgents(selectId = '#agentSelect') {
    $.ajax({
        url: window.routes.agentActive,
        method: "GET",
        success: function(data) {
            let select = $(selectId);
            select.empty();
            select.append('<option value="" disabled selected>Select a Agent</option>');
            data.forEach(function(agent) {
                select.append(`<option value="${agent.id}">${agent.first_name} ${agent.last_name}</option>`);
            });
        },
        error: function(xhr) {
            console.error("Failed to fetch employee:", xhr);
        }
    });
}

function fetchDelegates(selectId = '#delegateSelect') {
    $.ajax({
        url: window.routes.delegateActive,
        method: "GET",
        success: function(data) {
            let select = $(selectId);
            select.empty();
            select.append('<option value="" disabled selected>Select a Agent</option>');
            data.forEach(function(agent) {
                select.append(`<option value="${agent.id}">${agent.first_name} ${agent.last_name}</option>`);
            });
        },
        error: function(xhr) {
            console.error("Failed to fetch employee:", xhr);
        }
    });
}



function fetchBranch(selectId = '#branchSelect') {
    $.ajax({
        url: window.routes.branchActive,
        method: "GET",
        success: function(data) {
            let select = $(selectId);
            select.empty();
            select.append('<option value="" disabled selected>Select a branch</option>');
            data.forEach(function(branch) {
                select.append(`<option value="${branch.id}">${branch.name}</option>`);
            });
        },
        error: function(xhr) {
            console.error("Failed to fetch branch:", xhr);
        }
    });
}

function fetchBranchData(companyId, selectId = '#branchSelect') {
    if (!companyId) return;

    $.ajax({
        url: window.routes.branchActive,
        method: "GET",
        data: { company_id: companyId }, // Pass company_id in query
        success: function(data) {
            let select = $(selectId);
            select.empty();
            select.append('<option value="" disabled selected>Select a branch</option>');
            data.forEach(function(branch) {
                select.append(`<option value="${branch.id}">${branch.name}</option>`);
            });
        },
        error: function(xhr) {
            console.error("Failed to fetch branch:", xhr);
        }
    });
}

function fetchRouters(branchId, selectId = '#routerSelect') {
    if (!branchId) return;

    $.ajax({
        url: window.routes.routerActive,
        method: "GET",
        data: { branch_id: branchId },
        success: function(data) {
            let select = $(selectId);
            select.empty();
            select.append('<option value="" disabled selected>Select a router</option>');
            data.forEach(function(router) {
                select.append(`<option value="${router.id}">${router.host} (PORT-${router.port})</option>`);
            });
        },
        error: function(xhr) {
            console.error("Failed to fetch routers:", xhr);
        }
    });
}


function fetchCompanyData(selectId = '#companySelect') {
    $.ajax({
        url: window.routes.companyActive,
        method: "GET",
        success: function(data) {
            let select = $(selectId);
            select.empty();
            select.append('<option value="" disabled selected>Select a company</option>');
            data.forEach(function(company) {
                select.append(`<option value="${company.id}">${company.company_name }</option>`);
            });
        },
        error: function(xhr) {
            console.error("Failed to fetch company:", xhr);
        }
    });
}

let districtMap = {};

// On document ready
$(document).ready(function () {

    // When a district is selected, update the division field
    $('#districtsSelect').on('change', function () {
        const districtId = $(this).val();
        const district = districtMap[districtId];

        if (district && district.division_id) {
            $('#divisionsSelect').val(district.division_id).trigger('change');
        }
    });
});


function fetchProcessCategory(selectId = '#processCategorySelect') {
    $.ajax({
        url: window.routes.processCategoryActive,
        method: "GET",
        success: function(data) {
            let select = $(selectId);
            select.empty();
            select.append('<option value="" disabled selected>Select a Process Category</option>');
            data.forEach(function(process) {
                select.append(`<option value="${process.id}">${process.name}</option>`);
            });
        },
        error: function(xhr) {
            console.error("Failed to fetch employee:", xhr);
        }
    });
}

function fetchJobCategory(selectId = '#jobCategorySelect') {
    $.ajax({
        url: window.routes.jobCategoryActive,
        method: "GET",
        success: function(data) {
            let select = $(selectId);
            select.empty();
            select.append('<option value="" disabled selected>Select a Job Category</option>');
            data.forEach(function(job) {
                select.append(`<option value="${job.id}">${job.name}</option>`);
            });
        },
        error: function(xhr) {
            console.error("Failed to fetch employee:", xhr);
        }
    });
}

function fetchJobCategoryData(ProcessCategoryId, selectId = '#jobCategorySelect') {
    if (!ProcessCategoryId) return;

    $.ajax({
        url: window.routes.jobCategoryActive,
        method: "GET",
        data: { process_category_id: ProcessCategoryId },
        success: function(data) {
            let select = $(selectId);
            select.empty();
            select.append('<option value="" disabled selected>Select a Process Category</option>');
            data.forEach(function(job) {
                select.append(`<option value="${job.id}">${job.name}</option>`);
            });
        },
        error: function(xhr) {
            console.error("Failed to fetch branch:", xhr);
        }
    });
}

function fetchJobList(jobCategoryId, selectId = '#jobListSelect') {
    if (!jobCategoryId) return;
    $.ajax({
        url: window.routes.jobListActive,
        method: "GET",
        data: { job_category_id: jobCategoryId },
        success: function(data) {
            let select = $(selectId);
            select.empty();
            select.append('<option value="" disabled selected>Select a Job List</option>');
            data.forEach(function(job) {
                select.append(`<option value="${job.id}">${job.name}</option>`);
            });
        },
        error: function(xhr) {
            console.error("Failed to fetch employee:", xhr);
        }
    });
}

function fetchprocessOffice(selectId = '#processOfficeSelect') {
    $.ajax({
        url: window.routes.processOfficeActive,
        method: "GET",
        success: function(data) {
            let select = $(selectId);
            select.empty();
            select.append('<option value="" disabled selected>Select a process Office</option>');
            data.forEach(function(process) {
                select.append(`<option value="${process.id}">${process.name}</option>`);
            });
        },
        error: function(xhr) {
            console.error("Failed to fetch employee:", xhr);
        }
    });
}

