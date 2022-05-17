
 function getDate()
 {
    var d= new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' +
    (month<10 ? '0' : '') + month + '-' +
    (day<10 ? '0' : '') + day;

    return output;
 }

$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    var interval = setInterval(function() {
        var momentNow = moment();
        $('#date-part').html(momentNow.format('MMMM DD YYYY') + ' '
                            + momentNow.format('dddd')
                             .substring(0,3).toUpperCase());
        $('#time-part').html(momentNow.format('hh:mm:ss A'));

    }, 100);

    $('#btn_logout').on('click', function(){
        $.session.clear();
    })

    $.fn.modal.Constructor.prototype._enforceFocus = function() {};

    $('[data-toggle="tooltip"]').tooltip();



///////
});
