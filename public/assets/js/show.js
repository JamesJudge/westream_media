var dataTable;

$(".dateTime").datetimepicker({
    format: 'yyyy-mm-dd hh:ii',
    autoclose: true,
    todayBtn: true,
    minuteStep: 15,
    fontAwesome: true,
    startDate: moment().format("YYYY-MM-DD HH:mm")
});

function getShows() {
    $.get("/api/shows", function(data, status) {
        if(status == 'success'){
            gotShows(data);
        }else{
            alert("Ajax error occurred");
            console.log(data);
            console.log(data.length);
        }
    });
}

function gotShows(showData) {
    var table = $("#tbody-show");
    table.empty();

    if(showData.length < 1) {
        table.innerHTML = '<tr><td colspan="5">No records found</td></tr>';
        return false;
    }

    //Add the data rows.
    var cell = "";
    var row = "";
    $.each(showData, function(index, data) {
        // writing out line to debug console
        row = $("<tr id='"+ data.id +"'/>");

        cell = $("<td />");
        cell.html("<a href='#'  onclick=\"viewRow('" + data.id + "')\">" + data.eventName +"</a>");
        row.append(cell);

        cell = $("<td />");
        cell.html("<a href='#'  onclick=\"viewRow('" + data.id + "')\">" + data.recordedLink +"</a>");
        row.append(cell);

        cell = $("<td />");
        cell.html("<a href='#'  onclick=\"viewRow('" + data.id + "')\">" + moment.unix(data.start.timestamp).format("YYYY-MM-DD HH:mm") +"</a>");
        row.append(cell);

        cell = $("<td />");
        cell.html("<a href='#'  onclick=\"viewRow('" + data.id + "')\">" + moment.unix(data.end.timestamp).format("YYYY-MM-DD HH:mm") +"</a>");
        row.append(cell);

        cell = $("<td />");
        cell.html("<a href='#'  onclick=\"viewRow('" + data.id + "')\">" + data.amount +"</a>");
        row.append(cell);

        cell = $("<td />");
        cell.html("<a href='#'  onclick=\"viewRow('" + data.id + "')\">" + data.user.nickname +"</a>");
        row.append(cell);

        table.append(row);
    });

    dataTable = $("#showTable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
};

getShows();

function addShow() {
    $.when(getUserList('venue')).then(function(userData, textStatus, jqXHR) {
        if (userData.length) {
            var selTag = $('<select>').attr({'id': 'frm-user', 'required': true, 'class': 'selectTag'});
            selTag.append($("<option>").attr('value', '').text('Select Venue'));
            $(userData).each(function(index, data) {
                selTag.append($("<option>").attr('value', data.id).text(data.nickname));
            });

            $('#formUserList').html(selTag);
        }

        document.forms['showForm'].reset();
        document.getElementById('form-title').innerHTML = 'Add Show';

        $('.succMsg').addClass('hide');
        $('#addShowForm').removeClass('hide');
        $('#editShowForm').addClass('hide');

        $('#modal-show-form').modal();
    });
}

$("#addShowForm").on("submit", function(e) {
    e.preventDefault();

    var eventName, recordedLink, start, end, amount, user, showData, errorCounter;

    showData = {
        event_name: $("#frm-eventName").val(),
        recorded_link: $("#frm-recordedLink").val(),
        start: $("#frm-start").val(),
        end: $("#frm-end").val(),
        amount: $("#frm-amount").val(),
        user: $("#frm-user").val()
    };

    errorCounter = 0;
    $.each(showData, function(index, data) {
        if (data == '') {
            errorCounter++;
        }
    });

    if (errorCounter) {
        return;
    }

    $.ajax({
        url: "/api/show",
        method: 'POST',
        data: showData,
        beforeSend: function() {
            hideSuccMessage();
        },
        success: function(data) {
            gotShow(data);
            setTimeout(hideSuccMessage, 3000);
            showSuccMessage('Record added successfully');
        },
        complete: function() {
            editShowCancel();
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

function getUserList(userType) {
    return $.get("/api/users/" + userType, function(data, status) {
        if(status == 'success') {
            return data;
        } else {
            alert("Ajax error occurred");
            console.log(data);
            console.log(data.length);
        }
    });
}

function viewRow(rowIdentifier) {
    $.get("/api/show/" + rowIdentifier, function(data, status) {
        if(status == 'success') {
            showShow(data);
        } else {
            alert("Ajax error occurred");
            console.log(data);
            console.log(data.length);
        }
    });
}

function editClick() {
    $('.succMsg').addClass('hide');
    $('#addShowForm').addClass('hide');
    $('#editShowForm').removeClass('hide');

    $('#modal-show-form').modal({show:true});
    $('#modal-show-view').modal('hide');
}

function editCancel() {
    $('#modal-show-form').modal('hide');
}

function showShow(data){
    // TODO: add better error handling
    if(!data.length) {
        alert("No records found");
    }
    data = data[0];
    
    $("#view-id").html(data['id']);
    $("#form-id").val(data['id']);

    $("#view-eventName").html(data.eventName);
    $("#form-eventName").val(data.eventName);

    $("#view-recordedLink").html(data.recordedLink);
    $("#form-recordedLink").val(data.recordedLink);

    $("#view-start").html(moment.unix(data.start.timestamp).format("YYYY-MM-DD HH:mm"));
    $("#form-start").val(moment.unix(data.start.timestamp).format("YYYY-MM-DD HH:mm"));

    $("#view-end").html(moment.unix(data.end.timestamp).format("YYYY-MM-DD HH:mm"));
    $("#form-end").val(moment.unix(data.end.timestamp).format("YYYY-MM-DD HH:mm"));

    $("#view-amount").html(data.amount);
    $("#form-amount").val(data.amount);

    $("#view-user").html(data.user.nickname);
    $("#edit-form-user").html(data.user.nickname);

    document.getElementById('view-title').innerHTML = 'View Show - ' + data.eventName + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    document.getElementById('form-title').innerHTML = 'Edit Show - ' + data.eventName + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    $('#modal-show-view').modal();
}

function editShowCancel(){
    $('#modal-show-form').modal('hide');
}

$("#editShowForm").on("submit", function(e) {
    e.preventDefault();

    var showId, showData, errorCounter;

    showId = $("#form-id").val();
    showData = {
        event_name: $("#form-eventName").val(),
        recorded_link: $("#form-recordedLink").val(),
        start: $("#form-start").val(),
        end: $("#form-end").val(),
        amount: $("#form-amount").val()
    };

    errorCounter = 0;
    $.each(showData, function(index, data) {
        if (data == '') {
            errorCounter++;
        }
    });

    if (errorCounter) {
        return;
    }

    $.ajax({
        url: "/api/show/" + showId,
        method: 'PUT',
        data: showData,
        beforeSend: function() {
            hideSuccMessage();
        },
        success: function(data) {
            gotShow(data);
            setTimeout(hideSuccMessage, 3000);
            showSuccMessage('Record edited successfully');
        },
        complete: function() {
            editShowCancel();
        },
        error: function() {
            alert("Error occurred");
        }
    });    
});

function gotShow(data){
    //wdit show modal
    document.forms['showForm'].reset();

    $("#form-id").val(data.id);
    $("#form-eventName").val(data.eventName);
    $("#form-recordedLink").val(data.recordedLink);
    $("#form-start").val(moment.unix(data.start.timestamp).format("YYYY-MM-DD HH:mm"));
    $("#form-end").val(moment.unix(data.end.timestamp).format("YYYY-MM-DD HH:mm"));
    $("#form-amount").val(data.amount);
    $("#edit-form-user").val(data.user.nickname);

    document.getElementById('form-title').innerHTML = 'Edit Show - ' + data.eventName + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    $('#modal-show-form').modal();

    dataTable.destroy();
    getShows();
}
