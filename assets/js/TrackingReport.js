$(function () {

    var trackingreportTbl;
    reload_table()
    function reload_table(){
        var Search = $('#Search').val();
        var State = $('#State').val();
        var From = $('#From').val();
        var To = $('#To').val();
        trackingreportTbl = $('#trackingreportTbl').DataTable({
            'scrollX': true,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': 'TrackingReport-table.php',
                'data': {
                    'Search'    : Search,
                    'State'     : State,
                    'From'      : From,
                    'To'        : To,
                }
            },
            'columnDefs': [ {
                orderable: false,
                targets:   0
            }],
            'select': {
                style:    'os',
                selector: 'td:first-child'
            },
            'order': [[ 1, 'asc' ]],
            'columns': [
                { data: 'chkbox' },
                { data: 'BatchId' },
                { data: 'Jurisdiction' },
                { data: 'Title' },
                { data: 'JobName' },
                { data: 'Filename' },
                { data: 'ProcessCode' },
                { data: 'AssignedTo' },
                { data: 'StatusString' },
                { data: 'Relevancy' },
                { data: 'HoldRemarks' },
                { data: 'DateRegistered' }
            ]
        });
    }

    $(document).on('click', '.Search-btn', function(){
        
        trackingreportTbl.destroy();
        reload_table()
    })

    $(document).on('submit', '#UnholdJobform', function(e){
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {
                // console.log(data)
               $(".trCheckbox:checked").each(function(){
                    var tr = $(this).closest('tr')
                    var status = $(this).attr('data-status');
                    if(status == 'Hold'){
                        $(this).prop('checked', false);
                        tr.find('.StatusString').text('Allocated')
                    }
                })

                var len = $(".trCheckbox:checked").length;
                if(len <= 0){
                    $('.prCheckbox').prop('checked', false);
                    $('.allocate-btn').addClass('displaynone');
                    $('.unhold-btn').addClass('displaynone');
                    // trackingreportTbl.ajax.reload();
                }
                $('#unholdModal').modal('hide');
            }
        });
    })

    $(document).on('submit', '#allocateForm', function(e){
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {
                // console.log(data)
               $(".trCheckbox:checked").each(function(){
                    var tr = $(this).closest('tr')
                    var status = $(this).attr('data-status');
                    if(status == 'New'){
                        tr.remove();
                    }
                })

                var len = $(".trCheckbox:checked").length;
                if(len <= 0){
                    $('.prCheckbox').prop('checked', false);
                    $('.allocate-btn').addClass('displaynone')
                    $('.unhold-btn').addClass('displaynone')
                    // trackingreportTbl.ajax.reload();
                }
                $('#allocateModal').modal('hide');
            }
        });
    })

    $(document).on('submit', '#ReflowProcessform', function(e){
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {
                console.log(data)
                $(".trCheckbox:checked").each(function(){
                    var tr = $(this).closest('tr')
                    tr.remove();
                })

                var len = $(".trCheckbox:checked").length;
                if(len <= 0){
                    $('.prCheckbox').prop('checked', false);
                    $('.allocate-btn').addClass('displaynone')
                    $('.unhold-btn').addClass('displaynone');
                    // trackingreportTbl.ajax.reload();
                }
                $('#reflowModal').modal('hide');
            }
        });
    })
    
    $(document).on('change', '.trCheckbox', function(){
        var len = $(".trCheckbox:checked").length;
        if(len > 0){
            $('.allocate-btn').removeClass('displaynone')
            $('.unhold-btn').removeClass('displaynone')
        }else{
          $('.allocate-btn').addClass('displaynone')
          $('.unhold-btn').addClass('displaynone')
          $('.prCheckbox').prop('checked', false);
        }
    });

    $(document).on('change', '.prCheckbox', function(){
        if($(this).is(':checked')) {
           $('.trCheckbox').prop('checked', true);
           $('.allocate-btn').removeClass('displaynone')
            $('.unhold-btn').removeClass('displaynone')
        }else{
          $('.trCheckbox').prop('checked', false);
          $('.allocate-btn').addClass('displaynone')
          $('.unhold-btn').addClass('displaynone')
        }
    });

    $(document).on('click', '.allocate-btn', function(){
        var ctr = 0;
        $('#allocateTbl').html('')
        $(".trCheckbox:checked").each(function(){
            var status = $(this).attr('data-status');
            var BatchID = $(this).val();
            if(status == 'New'){
                ctr++;
                var tr = '<tr><td><input type="text" class="form-control abatchid input-sm" name="abatchid[]" value="'+BatchID+'" readonly/>';
                $('#allocateTbl').append(tr)
            }
        })
        if(ctr > 0){
            $('#allocateModal').modal();
        }else{
            alert('No batch available for allocation')
        }
    })

    $(document).on('click', '.unhold-btn', function(){
        var ctr = 0;
        $('#unholdTbl').html('')
        $(".trCheckbox:checked").each(function(){
            var status = $(this).attr('data-status');
            var BatchID = $(this).val();
            if(status == 'Hold'){
                ctr++;
                var tr = '<tr><td><input type="text" class="form-control uhbatchid input-sm" name="uhbatchid[]" value="'+BatchID+'" readonly/>';
                $('#unholdTbl').append(tr)
            }
        })

        if(ctr > 0){
            $('#unholdModal').modal();
        }else{
            alert('No batch available for un-hold')
        }
    })

    $(document).on('click', '.reflow-btn', function(){
        var len = $(".trCheckbox:checked").length;
        $('#reflowTbl').html('')
        if(len > 0){
            $(".trCheckbox:checked").each(function(){
                var BatchID = $(this).val();
                var tr = '<tr><td><input type="text" class="form-control rfbatchid input-sm" name="rfbatchid[]" value="'+BatchID+'" readonly/>';
                $('#reflowTbl').append(tr)
            })
            $('#reflowModal').modal()
        }else{
            alert('No batch available for reflow')
        }      
    })

    $(document).on('click', '.delete-btn', function(){
        var len = $(".trCheckbox:checked").length;
        if(len > 0){
            $(".trCheckbox:checked").each(function(){
                var JobId = $(this).closest('tr').attr('id');
                var tr = '<tr><td><input type="text" class="form-control delJobid input-sm" name="delJobid[]" value="'+JobId+'" readonly/>';
                $('#deleteTbl').append(tr)
            })
            $('#deleteModal').modal()
        }else{
            alert('No batch available for delete')
        } 
    })

    $(document).on('submit', '#deletebatchForm', function(e){
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {
                $(".trCheckbox:checked").each(function(){
                    var tr = $(this).closest('tr')
                    tr.remove();
                })

                var len = $(".trCheckbox:checked").length;
                if(len <= 0){
                    $('.prCheckbox').prop('checked', false);
                    $('.allocate-btn').addClass('displaynone')
                    $('.unhold-btn').addClass('displaynone')
                    // trackingreportTbl.ajax.reload();
                }
                $('#deleteModal').modal('hide');
            }
        });
    })
       
})

function DeleteRecord(){
         
        var BatchID=document.getElementById("BatchID").value;
      
        
        var data = 'data='+BatchID;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
          if (xmlhttp.readyState==4 && xmlhttp.status==200){
            //response.innerHTML=xmlhttp.responseText;
            document.getElementById(BatchID).style.display='none';
            alert("File successfully deleted!");
            // location.reload();
          }
        }
        xmlhttp.open("POST","DeleteRecord.php",true);
              //Must add this request header to XMLHttpRequest request for POST
              xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(data);
}

