var dataTable;

function getUserTypes() {
    $.get("/api/userTypes", function(data, status) {
        if(status == 'success'){
            gotUserType(data);
        }else{
            alert("Ajax error occurred");
            console.log(data);
            console.log(data.length);
        }
    });
}

function gotUserType(userTypeData) {
    var table = $("#tbody-userType");
    table.empty();

    if(userTypeData.length < 1) {
        table.html('<tr><td colspan="6" align="center">No records found</td></tr>');
        return false;
    }

    //Add the data rows.
    var cell = "";
    var row = "";
    $.each(userTypeData, function(index, data) {
        // writing out line to debug console
        row = $("<tr id='"+ data.id +"'/>");

        cell = $("<td />");
        cell.html("<a href='#'  onclick=\"viewRow('" + data.id + "')\">" + data.type +"</a>");
        row.append(cell);

        cell = $("<td />");
        cell.html("<a href='#'  onclick=\"viewRow('" + data.id + "')\">" + data.name +"</a>");
        row.append(cell);

        table.append(row);
    });

    dataTable = $("#userTypeTable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
};

getUserTypes();

function addUserType() {
    document.forms['addUserTypeForm'].reset();
    document.getElementById('form-title').innerHTML = 'Add User Type';

    hideSuccMessage();

    $('#addUserTypeForm').removeClass('hide');
    $('#editUserTypeForm').addClass('hide');

    $('#modal-userType-form').modal();
}

$("#addUserTypeForm").on("submit", function(e) {
    e.preventDefault();

    var userTypeData, errorCounter;

    userTypeData = {
        type: $("#frm-type").val(),
        name: $("#frm-name").val(),
    };

    errorCounter = 0;
    $.each(userTypeData, function(index, data) {
        if (data == '') {
            errorCounter++;
        }
    });

    if (errorCounter) {
        return;
    }

    $.ajax({
        url: "/api/userType",
        method: 'POST',
        data: userTypeData,
        beforeSend: function() {
            hideSuccMessage();
        },
        success: function(data) {
            gotLatestUserTypes(data);
            setTimeout(hideSuccMessage, 3000);
            showSuccMessage('Record added successfully');
        },
        complete: function() {
            editUserTypeCancel();
        },
        error: function() {
            alert("Error occurred");
        }
    });
});

function showSuccMessage (message) {
    $('.succMsg').html(message);
    $('.succMsg').removeClass('hide');
}

function hideSuccMessage () {
    $('.succMsg').html('');
    $('.succMsg').addClass('hide');
}

function viewRow(rowIdentifier) {
    $.get("/api/userType/" + rowIdentifier, function(data, status) {
        if(status == 'success') {
            showUserType(data);
        } else {
            alert("Ajax error occurred");
            console.log(data);
            console.log(data.length);
        }
    });
}

function editClick() {
    $('.succMsg').addClass('hide');
    $('#addUserTypeForm').addClass('hide');
    $('#editUserTypeForm').removeClass('hide');

    $('#modal-userType-form').modal({show:true});
    $('#modal-userType-view').modal('hide');
}

function editCancel() {
    $('#modal-userType-form').modal('hide');
}

function showUserType(data){
    // TODO: add better error handling
    if(!data.length) {
        alert("No records found");
    }
    data = data[0];
    
    $("#view-id").html(data['id']);
    $("#form-id").val(data['id']);

    $("#view-type").html(data.type);
    $("#form-type").val(data.type);

    $("#view-name").html(data.name);
    $("#form-name").val(data.name);

    document.getElementById('view-title').innerHTML = 'View User Type - ' + data.name + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    document.getElementById('form-title').innerHTML = 'Edit User Type - ' + data.name + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    $('#modal-userType-view').modal();
}

function editUserTypeCancel(){
    $('#modal-userType-form').modal('hide');
}

$("#editUserTypeForm").on("submit", function(e) {
    e.preventDefault();

    var userTypeId, userTypeData, errorCounter;

    userTypeId = $("#form-id").val();
    userTypeData = {
        type: $("#form-type").val(),
        name: $("#form-name").val(),
    };

    errorCounter = 0;
    $.each(userTypeData, function(index, data) {
        if (data == '') {
            errorCounter++;
        }
    });

    if (errorCounter) {
        return;
    }

    $.ajax({
        url: "/api/userType/" + userTypeId,
        method: 'PUT',
        data: userTypeData,
        beforeSend: function() {
            hideSuccMessage();
        },
        success: function(data) {
            gotLatestUserTypes(data);
            setTimeout(hideSuccMessage, 3000);
            showSuccMessage('Record edited successfully');
        },
        complete: function() {
            editUserTypeCancel();
        },
        error: function() {
            alert("Error occurred");
        }
    });    
});

function gotLatestUserTypes(data) {
    $("#form-id").val(data.id);
    $("#form-type").val(data.type);
    $("#form-name").val(data.name);

    document.getElementById('form-title').innerHTML = 'Edit User Type - ' + data.name + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    $('#modal-userType-form').modal();

    dataTable.destroy();
    getUserTypes();
}
