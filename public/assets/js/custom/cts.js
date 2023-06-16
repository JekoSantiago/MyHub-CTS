function isEveryInputEmpty() {
    var allEmpty = true;
    $('form#form_denom :input:not([type=hidden])').each(function() {
        if ($(this).val() !== '') {
            allEmpty = false;
            return false; // we've found a non-empty one, so stop iterating
        }
    });

    return allEmpty;
}

function getDate(){
    var d = new Date();

    var month = d.getMonth()+1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' +
    ((''+month).length<2 ? '0' : '') + month + '-' +
    ((''+day).length<2 ? '0' : '') + day;

    return output;
}


$(document).ready(function() {

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

        $('#modal_new_cts').on('hidden.bs.modal',function(){

            $('#cts_shift').val(0);

        });




    $('#btn_add_cts').on('click',function(){
        $(this).attr('disabled',true)
        $(this).text('Saving...')
        var error = false
        var date = $('#cts_date').val();
        var shift = $('#cts_shift').val();

        if(date.length == 0)
        {
            error = true;
            $('#cts_date').addClass('error-input');
            $('#cts_date_error').show();
        }
        else
        {
            $('#cts_date').removeClass('error-input');
            $('#cts_date_error').hide();
        }

        if(shift <=0)
        {
            error = true;
            $('#cts_shift').addClass('error-input');
            $('#cts_shift_error').show();
        }
        else
        {
            $('#cts_shift').removeClass('error-input');
            $('#cts_shift_error').hide();
        }

        if (error == false)
        {
            $('.invalid-feedback').hide();

            swal.fire({
                title: 'Are you sure?',
                text: "Adding new CTS",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
                }).then((result) => {
                if(result.value)
                {
                    var formdata = $('#form_new_cts').serialize();
                    $.post(WebURL + '/cts-insert',formdata,function(data){
                        if(data.num>0)
                        {
                            console.log(data);
                            swal.fire({
                                title: 'Success',
                                text: data.msg,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                                }).then(function (result) {
                                    if (true) {
                                        $('#modal_new_cts').modal('hide');
                                        tblCTS.ajax.reload(null,false)
                                        $('#btn_add_cts').attr('disabled',false)
                                        $('#btn_add_cts').text('Save')
                                    }
                                    })
                        }
                        else
                        {
                            swal.fire({
                                title: "Warning!",
                                text: data.msg,
                                icon: "warning",
                                confirmButtonText: "Ok",
                                confirmButtonColor: '#6658dd',
                                allowOutsideClick: false,
                            });
                        }
                    },'JSON');
                }

                });


        }
        else {
            $('.error-input').filter(":first").focus();
        }

    })

    var tblCTS = $('#tbl_CTS').DataTable({
        autoWidth: true,
        serverSide: true,
        scrollX: true,
        ordering: false,
        lengthChange: false,
        ajax: {
            url: WebURL + '/cts-get',
            method: 'POST',
            datatype: 'json',
            data: function (data) {
                var filter_dateFrom  = $('#filter_dateFrom').val();
                var filter_dateTo  = $('#filter_dateTo').val();
                data.filter_dateFrom  = filter_dateFrom;
                data.filter_dateTo = filter_dateTo;

            },
            beforeSend: function () {
                $('#tbl_CTS > tbody').html(
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
            {
                render: function (data, type, row, meta) {
                    var btn = ''
                    if (parseInt(row.PickupCount) < 5 && row.CTSDate == getDate() && row.InsertBy == userID)
                    {
                        btn = '<a href="javascript:void(0)" class="action-icon text-success"  data-toggle="tooltip" data-placement="top" title="ENCODE"><i class="mdi mdi-account-cash-outline denum"></i></a>';
                    }

                    return  btn;
                },
                className: 'text-center',
            },
            {data:'CTSNumber'},
            {data:'FullName'},
            {data:'Location'},
            {data:'CTSDate'},
            {data:'Shift'}

        ],
        drawCallback: function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        },

    });

    $('#btn_filter_cts').on('click', function () {
        $('#modal_filter_cts').modal('hide');
        tblCTS.draw();
    });

    $('body').on('click','.denum',function(e){

        var data = tblCTS.row( $(this).parents('tr') ).data();
        var pc = parseInt(data.PickupCount);
        var ctsID = parseInt(data.CTS_ID);

        swal.fire({
            title:'Pick-up or Endshift?',
            icon:'question',
            html:'<br><button type="button" id="pickup" class="btn btn-info">Pick-Up</button> &emsp;' +
                 '<button type="button" id="endshift" class="btn btn-success">Endshift</button><br><br>',
            showConfirmButton: false,
            onOpen: function(el) {
                var container = $(el);
                if(pc == 4)
                {
                    container.find('#pickup').prop("disabled",true);

                }
            },
        })

        $('#pickup').on('click',function(){
            pc = pc+1;
            swal.close()
            $('#modal_denom').modal('show');
            $('#cts_ID').val(ctsID)
            $('#pickup_type').val(pc)
            $('.endopt').hide();
            $.get(WebURL+'/denom-pickup/'+pc,function(res){
                $('#picktitle').text(res[0].PickupType);
            },'JSON');


        })

        $('#endshift').on('click',function(){
            pc = 5;
            swal.close()
            $('#modal_denom').modal('show');
            $('#cts_ID').val(ctsID)
            $('#pickup_type').val(pc)
            $('.endopt').show();
            $.get(WebURL+'/denom-pickup/'+pc,function(res){
                $('#picktitle').text(res[0].PickupType);
            },'JSON');
        })


        $('#btn_save_denom').on('click',function(){

            var error = false;
            var type = $('#pickup_type').val();
            var lcf = $('#denom_lcf').val();
            var lcc = ($('#denom_lcc').val());
            var b1 = ($('#13').val() || 0);
            var b2 = ($('#12').val() || 0);
            var b3 = ($('#11').val() || 0);
            var b4 = ($('#10').val() || 0);
            var b5 = ($('#9').val() || 0);
            var b6 = ($('#8').val() || 0);
            var c1 = ($('#7').val() || 0);
            var c2 = ($('#6').val() || 0);
            var c3 = ($('#5').val() || 0);
            var c4 = ($('#4').val() || 0);
            var c5 = ($('#3').val() || 0);
            var c6 = ($('#2').val() || 0);
            var c7 = ($('#1').val() || 0);

            console.log(type,lcf.length,lcc.length);

            if(type == 5)
            {
                if(lcf.length <= 0)
                {
                    error = true;
                    $('#denom_lcf').addClass('error-input');
                    $('#denom_lcf_error').show();
                }
                else
                {
                    if(parseFloat(lcf) <= 0)
                    {
                        error = true;
                        $('#denom_lcf').addClass('error-input');
                        $('#denom_lcf_error').show();
                    }
                    else
                    {
                        $('#denom_lcf').removeClass('error-input');
                        $('#denom_lcf_error').hide();
                    }

                }

                if(lcc.length == 0)
                {
                    error = true;
                    $('#denom_lcc').addClass('error-input');
                    $('#denom_lcc_error').show();
                }
                else
                {
                    $('#denom_lcc').removeClass('error-input');
                    $('#denom_lcc_error').hide();
                }
            }

            if(isEveryInputEmpty())
            {
                error = true;
                Swal.fire({
                    icon: 'warning',
                    text: 'Empty Denomination',
                  })
            }

            if (error == false)
            {
                formdata = $('#form_denom').serialize();
                var total = (parseFloat(b1) * 1000) + (parseFloat(b2) * 500) +
                            (parseFloat(b3) * 200)  + (parseFloat(b4) * 100) +
                            (parseFloat(b5) * 50) + (parseFloat(b6) * 20) +
                            (parseFloat(c1) * 20) + (parseFloat(c2) * 10) +
                            (parseFloat(c3) * 5) + (parseFloat(c4) * 1) +
                            (parseFloat(c5) * 0.25) + (parseFloat(c6) * 0.05) +
                            (parseFloat(c7) * 0.01);

                swal.fire({
                title: 'Review Denomination',
                confirmButtonText :'CONFIRM',
                focusConfirm: false,
                html:
                '<table style="border: none;" class="table table-center table-md">'+
                    '<thead>' +
                        '<tr>'+
                            '<th>Bills</th>'+
                            '<th>Coins</th>'+
                        '</tr>'+
                    '</thead>' +
                    '<tbody>' +
                        '<tr>' +
                            '<td>1,000.00 <b>x'+($('#13').val() || 0)+'</b></td>'+
                            '<td>20.00 <b>x'+($('#7').val() || 0)+'</b></td>'+
                        '</tr>' +
                        '<tr>' +
                            '<td>500.00 <b>x'+($('#12').val() || 0)+'</b></td>'+
                        '   <td>10.00 <b>x'+($('#6').val() || 0)+'</b></td>'+
                        '</tr>' +
                        '<tr>' +
                            '<td>200.00 <b>x'+($('#11').val() || 0)+'</b></td>'+
                            '<td>5.00 <b>x'+($('#5').val() || 0)+'</b></td>'+
                        '</tr>' +
                        '<tr>' +
                            '<td>100.00 <b>x'+($('#10').val() || 0)+'</b></td>'+
                            '<td>1.00 <b>x'+($('#4').val() || 0)+'</b></td>'+
                        '</tr>' +
                        '<tr>' +
                            '<td>50.00 <b>x'+($('#9').val() || 0)+'</b></td>'+
                            '<td>0.25 <b>x'+($('#3').val() || 0)+'</b></td>'+
                        '</tr>' +
                        '<tr>' +
                            '<td>20.00 <b>x'+($('#8').val() || 0)+'</b></td>'+
                            '<td>0.05 <b>x'+($('#2').val() || 0)+'</b></td>'+
                        '</tr>' +
                        '<tr>' +
                            '<td></td>'+
                            '<td>0.01 <b>x'+($('#1').val() || 0)+'</b></td>'+
                        '</tr>' +
                    '</tbody>'+
                '</table>'+
                '<div class="row ">'+
                    '<div class="col">This is to confirm the <br> total encoded denomination: <b>'+ total.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                      }) +'</b> </div>'+
                '</div>'+
                '<div class="row endsh pt-2 ">'+
                '<div class="col-3"></div>'+
                '<div class="col">'+
                '<div class="text-left">Loose Change Fund : <b> ' + parseFloat(lcf).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                  }) + ' </b></div>'+
                  '<div class="text-left">Check Encashment : <b> ' + parseFloat(lcc).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                  }) +' </b> </div>'+
                  '</div>'+
                '</div>' +
                '<div class="row">' +
                    '<div class="col"> <small class="text-danger"><b>*Note : Denomination and Amount cannot be updated once confirmed</b></small></div>'+
                '</div>',
                showCancelButton: true,
                onOpen: function() {
                    // $(swal.getConfirmButton()).prop('disabled', true)
                    // $('#confirmtxt').on('input',function(){
                    //     $(document).on("cut copy paste","#confirmtxt",function(e) {
                    //         e.preventDefault();
                    //     });
                    //     if($('#confirmtxt').val() == "CONFIRM")
                    //     {
                    //         $(swal.getConfirmButton()).prop('disabled', false)
                    //     }
                    //     else
                    //     {
                    //         $(swal.getConfirmButton()).prop('disabled', true)
                    //     }
                    // })

                    if(type == 5)
                    {
                        $('.endsh').show();
                    }
                    else
                    {
                        $('.endsh').hide();
                    }
                },
                }).then((result) => {
                if(result.value)
                {
                    $.post(WebURL + '/denom-insert',formdata,function(data){
                        if(data.num>0)
                        {
                            console.log(data);
                            swal.fire({
                                title: 'Success',
                                text: data.msg,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                                }).then(function (result) {
                                    if (true) {
                                        $('#modal_denom').modal('hide');
                                        $('#form_denom')[0].reset();
                                        tblCTS.ajax.reload(null,false)
                                    }
                                })
                        }
                        else
                        {
                            swal.fire({
                                title: "Warning!",
                                text: data.msg,
                                icon: "warning",
                                confirmButtonText: "Ok",
                                confirmButtonColor: '#6658dd',
                                allowOutsideClick: false,
                            });
                        }
                    },'JSON');
                }
                });
            }
        })
    })




///////
});
