var dataTable, userType;
userType = $('#userType').val();

function getUsers(){
    $.get("/api/users", function(data, status){
        if(status == 'success'){
            gotUsers(data);
        }else{
            alert("Ajax error occurred");
        }
    });
}

function gotUsers(userData) {
    var table = $("#tbody-companies");
    table.empty();

    if(userData.length < 1){
        table.html('<tr><td colspan="9" align="center">No records found</td></tr>');
        return false;
    }

    var cell = "";
    var row = "";

    $.each(userData, function(index, data) {
        row = $("<tr id='" + data.id + "'/>");

        cell = $("<td />");
        cell.html("<a href='#' onclick=\"viewUser('" + data.id + "')\">" + data.email + "</a>");
        row.append(cell);

        cell = $("<td />");
        cell.html("<a href='#' onclick=\"viewUser('" + data.id + "')\">" + data.firstName +"</a>");
        row.append(cell);

        cell = $("<td />");
        cell.html("<a href='#' onclick=\"viewUser('" + data.id + "')\">" + data.lastName +"</a>");
        row.append(cell);

        cell = $("<td />");
        cell.html("<a href='#' onclick=\"viewUser('" + data.id + "')\">" + data.nickname +"</a>");
        row.append(cell);

        cell = $("<td />");
        if (data.streamingKey) {
            cell.html("<a href='#' onclick=\"viewUser('" + data.id + "')\">" + data.streamingKey +"</a>");
        } else {
            cell.html("-");
        }
        row.append(cell);

        cell = $("<td />");
        if (data.profileImage) {
            cell.html("<a href='#' onclick=\"viewUser('" + data.id + "')\"><img class='imgScale' src='/assets/profile/" + data.profileImage +"' sca></a>");
        } else {
            cell.html("-");
        }
        row.append(cell);

        cell = $("<td />");
        if (data.category) {
            cell.html("<a href='#' onclick=\"viewUser('" + data.id + "')\">" + data.category +"</a>");
        } else {
            cell.html("-");
        }
        row.append(cell);

        cell = $("<td />");
        if (data.bio) {
            cell.html("<a href='#' onclick=\"viewUser('" + data.id + "')\">" + data.bio +"</a>");
        } else {
            cell.html("-");
        }
        row.append(cell);

        if (userType != 'venue') {
            cell = $("<td />");
            var dataUserType = (data.userType) ? data.userType.name : ((data.streamingKey) ? 'Venue' : 'Viewer');
            cell.html("<a href='#' onclick=\"viewUser('" + data.id + "')\">" + dataUserType +"</a>");
            row.append(cell);

            cell = $("<td />");
            cell.html("<a href='#' onclick=\"viewUser('" + data.id + "')\">" + (data.admin ? 'Yes' : 'No') +"</a>");
            row.append(cell);
        }

        table.append(row);
    });

    dataTable = $("#userTable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
};

getUsers();

function addUser() {
    document.forms['addUserForm'].reset();
    document.getElementById('form-title').innerHTML = 'Add User';

    hideSuccMessage();

    $('#addUserForm').removeClass('hide');
    $('#editUserForm').addClass('hide');

    $('#modal-user-form').modal();
}

function viewUser(userId) {
    $.get("/api/user/" + userId, function(data, status) {
        if(status == 'success') {
            showUser(data);
        }else{
            alert("Ajax error occurred");
        }
    });
}

function editClick() {
    $('.succMsg').addClass('hide');
    $('#addUserForm').addClass('hide');
    $('#editUserForm').removeClass('hide');

    $('#modal-user-form').modal({show:true});
    $('#modal-user-view').modal('hide');
}

function editCancel() {
    $('#modal-user-form').modal('hide');
}

function showUser(data){
    if(data.length != 1) {
        alert("ERROR = No reocrd found");
        return;
    }
    data = data[0];

    $("#view-id").html(data['id']);
    $("#form-id").val(data['id']);

    $("#view-email").html(data['email']);
    $("#form-email").val(data['email']);

    $("#view-password").html('********');
    $("#form-password").val('');

    // TODO: Actually hash passwords...
    $("#view-nickname").html(data['nickname']);
    $("#form-nickname").val(data['nickname']);

    $("#view-first-name").html(data['firstName']);
    $("#form-first-name").val(data['firstName']);

    $("#view-last-name").html(data['lastName']);
    $("#form-last-name").val(data['lastName']);

    $("#view-streaming-key").html(data['streamingKey']);
    $("#form-streaming-key").val(data['streamingKey']);

    $("#view-streaming-server").html(data['streamingServer']);
    $("#form-streaming-server").val(data['streamingServer']);

    if (data['profileImage']) {
        $("#view-profile-image").html('<img src="/assets/profile/' + data['profileImage'] + '" class="imgScale"/>');
        $("#form-profile-image-view").html('<img src="/assets/profile/' + data['profileImage'] + '" class="imgScale"/>');
        $("#form-profile-image").val(data['profileImage']);
    } else {
        $("#view-profile-image").html('');
        $("#form-profile-image-view").html('');
        $("#form-profile-image").val('');
    }

    $("#view-category").html(data['category']);
    $("#form-category").val(data['category']);

    $("#view-bio").html(data['bio']);
    $("#form-bio").val(data['bio']);

    $("#view-is-admin").html(data['admin'] ? 'Yes' : 'No');
    $("#form-is-admin").attr('checked', data['admin'] ? true : false);

    var viewUserType, viewUserTypeName, formUserType;
    viewUserType = (data.userType) ? data.userType.name : ((data.streamingKey) ? 'Venue' : 'Viewer');
    formUserType = (data.userType) ? data.userType.name : ((data.streamingKey) ? 'Venue' : 'Viewer');
    $("#view-user-type").html(viewUserType);
    $('#form-user-type option')
        .filter(function() { return $.trim( $(this).text() ) == formUserType; })
        .attr('selected','selected');

    document.getElementById('view-title').innerHTML = ((userType != 'venue') ? 'View User - ' : 'Viewer - ') + data['nickname'] + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    document.getElementById('form-title').innerHTML = 'Edit User - ' + data['nickname'] + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    if(data['streamingKey'] != null){
        $('#btnAddStream').hide();
        $('#btnRemoveStream').show();
    } else {
        $('#btnAddStream').show();
        $('#btnRemoveStream').hide();
    }
    $('#modal-user-view').modal();
}

function editUserCancel(){
    $('#modal-user-form').modal('hide');
}

function gotUser(data, userFormName){
    var formPredecessor = (userFormName == 'editUserForm') ? 'form' : 'frm';

    dataTable.destroy();
    getUsers();
}

function ucFirst(str) {
    return str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    });
}

$("#addUserForm, #editUserForm").on("submit", function(e) {
    e.preventDefault();

    $('.email-error, .nickname-error').html('');
    $('.email-error, .nickname-error').addClass('hide');

    var userForm, userFormName, formPredecessor, userId, userData, skipFields, errorCounter;
    userForm = $(e.target);
    userFormName = userForm[0].name;
    formPredecessor = (userFormName == 'editUserForm') ? 'form' : 'frm';

    userData = {
        email: $("#" + formPredecessor + "-email").val(),
        password: $("#" + formPredecessor + "-password").val(),
        nickname: $("#" + formPredecessor + "-nickname").val(),
        firstName: $("#" + formPredecessor + "-first-name").val(),
        lastName: $("#" + formPredecessor + "-last-name").val(),
        streamingKey: $("#" + formPredecessor + "-streaming-key").val(),
        streamingServer: $("#" + formPredecessor + "-streaming-server").val(),
        profileImage: $("#" + formPredecessor + "-profile-image").val(),
        category: $("#" + formPredecessor + "-category").val(),
        bio: $("#" + formPredecessor + "-bio").val(),
        userType: $("#" + formPredecessor + "-user-type").val(),
        isAdmin: $("#" + formPredecessor + "-is-admin").val(),
    };

    skipFields = ['passwordHash', 'streamingKey', 'streamingServer', 'profileImage', 'category', 'bio'];
    errorCounter = 0;
    $.each(userData, function(index, data) {
        if (data == '' && $.inArray(index, skipFields) == -1) {
            errorCounter++;
        }
    });

    if (errorCounter) {
        return;
    }

    var url, method, succMessage; 
    if (userFormName == 'editUserForm') {
        var userId = parseInt($("#" + formPredecessor + "-id").val());

        userData['id'] = userId;
        url = '/api/user/' + userId;
        succMessage = 'Record edited successfully';
        method = "PUT";
    } else {
        url = '/api/user';
        method = "POST";
        succMessage = 'Record added successfully';
    }

    $.ajax({
        url: url,
        method: method,
        data: userData,
        beforeSend: function() {
            $('.email-error, .nickname-error').html('');
            $('.email-error, .nickname-error').addClass('hide');
        },
        success: function(data) {
            gotUser(data, userFormName);
            setTimeout(hideSuccMessage, 3000);
            showSuccMessage(succMessage);
        },
        complete: function() {
            editUserCancel();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            if (jqXHR.status == 409) {
                var res = jqXHR.responseJSON;

                if (res.email) {
                    $('.email-error').html(res.email);
                    $('.email-error').removeClass('hide');
                }

                if (res.nickname) {
                    $('.nickname-error').html(res.nickname);
                    $('.nickname-error').removeClass('hide');
                }
            }
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

$("#form-image, #frm-image").on("change", function(e) {
    e.preventDefault();
    e.stopPropagation();

    var $file, file, userForm;
    $file = $(e.target);
    file = $file[0].files[0];
    userForm = ($file[0].id == 'frm-image') ? 'frm-profile-image' : 'form-profile-image';

    $.ajax({
        type: "POST",
        url: "/api/user/profileImage",
        data: file,
        processData: false,
        beforeSend: function (xhr) {
            $('.profile-image-error').html('');
            $('.profile-image-error').addClass('hide');

            xhr.setRequestHeader("Content-Type", "multipart/form-data");
            xhr.setRequestHeader("X-File-Name", file.name);
            xhr.setRequestHeader("X-File-Size", file.size);
            xhr.setRequestHeader("X-File-Type", file.type);
        },
        success: function (data) {
            $('#' + userForm).val(data.profileImage);
        },
        error: function (jqXHR) {
            var res = jqXHR.responseJSON;
            if (res.error) {
                $('.profile-image-error').html(res.error);
                $('.profile-image-error').removeClass('hide');
            }
            alert("Error occurred");
        }
    });
});