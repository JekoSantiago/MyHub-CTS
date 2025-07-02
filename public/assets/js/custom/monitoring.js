
$(document).ready(function() {

    $('#filter_store').select2();

    var date1 = $("#filter_dateFrom").flatpickr({
        onChange: function(selectedDates, dateStr, instance) {
            date2.set('minDate', dateStr)
        }
    })
    var date2 = $("#filter_dateTo").flatpickr({
        onChange: function(selectedDates, dateStr, instance) {
            date1.set('maxDate', dateStr)
        }
    })

    $('#modal_filter_mcts').on('hidden.bs.modal',function(){

        $('#filter_store').val(0);

    });



    var tblmCTS = $('#tbl_mCTS').DataTable({
        autoWidth: true,
        serverSide: true,
        scrollX: true,
        ordering: false,
        lengthChange: false,
        ajax: {
            url: WebURL + '/monitoring-get',
            method: 'POST',
            datatype: 'json',
            data: function (data) {
                var filter_dateFrom  = $('#filter_dateFrom').val();
                var filter_dateTo  = $('#filter_dateTo').val();
                var filter_store = $('#filter_store').val();
                data.filter_dateFrom  = filter_dateFrom;
                data.filter_dateTo = filter_dateTo;
                data.filter_store = filter_store;

            },
            beforeSend: function () {
                $('#tbl_mCTS > tbody').html(
                    '<tr class="odd">' +
                    '<td valign="top" colspan="7" class="dataTables_empty"><div class="text-center"><div class="spinner spinner-border"></div></div></td>' +
                    '</tr>'
                );
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 419)
                {
                    alert("Session Expired. Kindly Relogin Again.");
                }
                else
                {
                    alert("Processing data failed. Please report to the System Adminstator.");
                }

            },

        },
        language: {
            emptyTable: 'No data available.',
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        columns: [
            {
                render: function (data, type, row, meta) {
                    var btn = ''
                    if( row.CTSDate == getDate() && row.Print == 1 && DeptID == OpsID)
                    {

                        btn = '<a href="'+WebURL+'/monitoring-tally/'+row.CTSNumber+'" class="action-icon text-info" ><i class="mdi mdi-eye viewcts"></i></a> <a href="'+WebURL+'/cts-print2/'+row.CTSNumber+'/-1" class="action-icon text-warning" target="_blank" ><i class="mdi mdi-printer printc"></i></a>';
                    }
                    else if( row.CTSDate == getDate()  || DeptID != OpsID)
                    {
                        btn = '<a href="'+WebURL+'/monitoring-tally/'+row.CTSNumber+'" class="action-icon text-info" ><i class="mdi mdi-eye viewcts"></i></a>';
                    }
                    return  btn;
                }
            },
            {data:'CTSNumber'},
            {data:'Location'},
            {data:'CTSDate'},

        ],
        drawCallback: function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        },

    });

    $('#btn_filter_mcts').on('click', function () {
        var filter_dateFrom  = $('#filter_dateFrom').val();
        var filter_dateTo  = $('#filter_dateTo').val();
        var error = false;

        if(filter_dateFrom.length <= 0)
        {
            error = true;
            $('#filter_dateFrom').addClass('error-input');
            $('#filter_dateFrom_error').show();
        }
        else
        {
            $('#filter_dateFrom').removeClass('error-input');
            $('#filter_dateFrom_error').hide();
        }

        if(filter_dateTo.length <= 0)
        {
            error = true;
            $('#filter_dateTo').addClass('error-input');
            $('#filter_dateTo_error').show();
        }
        else
        {
            $('#filter_dateTo').removeClass('error-input');
            $('#filter_dateTo_error').hide();
        }

        if(error == false)
        {
            $('#modal_filter_mcts').modal('hide');
            tblmCTS.draw();
        }

    });


///////
});
