
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



    var tbl_audit = $('#tbl_audit').DataTable({
        autoWidth: true,
        serverSide: true,
        searching: false,
        scrollX: true,
        ordering: false,
        lengthChange: false,
        ajax: {
            url: WebURL + '/audit-get',
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
                $('#tbl_audit > tbody').html(
                    '<tr class="odd">' +
                    '<td valign="top" colspan="7" class="dataTables_empty"><div class="text-center"><div class="spinner spinner-border"></div></div></td>' +
                    '</tr>'
                );
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Processing data failed. Please report to the System Adminstator.");
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
            {data:'LocationCode'},
            {data:'Location'},
            {data:'Sched'},
            {data:'SalesDate',className:'text-right'},
            {data:'NetCash',className:'text-right',
            render: function (data, type, row, meta) {
            return  (row.NetCash > 0) ? parseFloat(row.NetCash).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              }) : '';
            }},
            {data:'DepositAmount',
            render: function (data, type, row, meta) {

                DepositAmount = parseFloat(row.DepositAmount).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                  });
                return  (row.DepositAmount > 0) ? '<a href="javascript:void(0)" data-image="1|'+row.Deposit_ID+'" data-toggle="modal" data-target="#modal_dpas" class=" text-info">'+DepositAmount+'</a>' : '';
            },className:'text-right'
            },
            {data:'VDA',
            render: function (data, type, row, meta) {

                VDepositAmount = parseFloat(row.VDA).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                  });
                var VDA = (row.VDA > 0) ? '<a href="javascript:void(0)" data-image="2|'+row.ValidatedDeposit_ID+'" data-toggle="modal" data-target="#modal_dpas" class=" text-info">'+VDepositAmount+'</a>': '';
                return VDA;
            },className:'text-right'},
            {data:'Discrepancy',className:'text-right',
            render: function (data, type, row, meta) {
                return (row.Discrepancy) ? parseFloat(row.Discrepancy).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                  }) : '';
                }},
            {data:'DPASRemarks',
            render: function (data, type, row, meta) {
                var dpasR = (row.DPASRemarks) ? row.DPASRemarks.toString() : '';
              return  (dpasR.length> 18) ?  '<a href="javascript:void(0)" data-remarks="'+dpasR+'" data-toggle="modal" data-target="#modal_remarks" class=" text-info">'+dpasR.substring(0, 17)+'</a>': dpasR;
            }
            },
            {data:'DPASby'},
            {data:'DPASdate'},
            {data:'VDSRemarks',
            render: function (data, type, row, meta) {
                var vdsR = (row.VDSRemarks) ? row.VDSRemarks.toString() : '';
              return  (vdsR.length> 18) ?  '<a href="javascript:void(0)" data-remarks="'+vdsR+'" data-toggle="modal" data-target="#modal_remarks" class=" text-info">'+vdsR.substring(0, 17)+'</a>': vdsR;
            }
            },
            {data:'VDAby'},
            {data:'VDAdate'}
        ],
        drawCallback: function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        },
        "createdRow": function( row, data, dataIndex ) {

            if(data.Discrepancy < 0)
            {
                $(row).children(':nth-child(8)').addClass('text-dangeseler');
                $(row).addClass('important');
            }


        },
    });

    $('#btn_filter_audit').on('click', function () {
        $('#modal_filter_audit').modal('hide');
        tbl_audit.draw();
    });

    $('#audit_dl').on('click',function(){

        if(tbl_audit.data().any())
        {
            var dateFrom = $('#filter_dateFrom').val();
            var dateTo = $('#filter_dateTo').val();
            var store = $('#filter_store').val();
            var param = btoa(dateFrom+'@@'+dateTo+'@@'+store)

            $(window.location).attr('href', WebURL + '/audit-dl/'+param);
        }
        else
        {
            swal.fire("Empty Report" ,"Filter first" , "warning");
        }

    })

    $('#modal_dpas').on('show.bs.modal', function(e) {
        var img  = $(e.relatedTarget).data('image');
        var res = img.split('|')
        $.post(WebURL + '/image-get',{res},function(data){
            $('#loader').hide();
            $('#attachment').show();
            $('#attachment').attr("src", data[0].Image);
        },'JSON');
    });

    $('#modal_dpas').on('hide.bs.modal', function(e) {
        $('#loader').show();
        $('#attachment').hide();
        $('#attachment').attr("src", "");
    });



    $('#modal_remarks').on('show.bs.modal', function(e) {
        var remarks  = $(e.relatedTarget).data('remarks');
        $('#dpas_remarks').text(remarks);
    });


///////
});
