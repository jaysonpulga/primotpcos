$(function () {
	$('#example2').DataTable({
      	'paging'      : true,
      	'lengthChange': true,
      	'searching'   : false,
      	'ordering'    : true,
      	'info'        : true,
      	'autoWidth'   : false
    })
})

function Verified(){
        
        var vremarks=document.getElementById("vremarks").value;
        var BatchID=document.getElementById("vBatchID").value;
        var JobID=document.getElementById("vJobID").value;
        if(vremarks==''){
            alert('Please enter a remark')
        }else{
            var data = 'data='+BatchID+"&JobID="+JobID+"&remarks="+vremarks;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange=function(){
              if (xmlhttp.readyState==4 && xmlhttp.status==200){
               console.log(xmlhttp.responseText)
                document.getElementById(BatchID).style.display='none';
                alert("File successfully verified!");
                // location.reload();
              }
            }
            xmlhttp.open("POST","VerifyRecord.php",true);
                  //Must add this request header to XMLHttpRequest request for POST
                  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send(data);
        }
        

      }
function MoveToRelevant(){
    var vremarks=document.getElementById("vremarks").value;
    var BatchID=document.getElementById("vBatchID").value;
    var JobID=document.getElementById("vJobID").value;
    if(vremarks==''){
        alert('Please enter a remark')
    }else{
      	var data = 'data='+BatchID+"&JobID="+JobID+"&remarks="+vremarks;
      	var xmlhttp = new XMLHttpRequest();
      	xmlhttp.onreadystatechange=function(){
      	  	if (xmlhttp.readyState==4 && xmlhttp.status==200){
      	  	  	console.log(xmlhttp.responseText);
      	  	  // document.getElementById(BatchID).style.display='none';
      	  	  // alert("File successfully verified!");
      	  	}
      	}
      	xmlhttp.open("POST","MoveToRelevant.php",true);
      	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      	xmlhttp.send(data);
    }
}
       function SetTextBoxBatch(BatchID, JobID) {
            // $('#modal-Verify #sTitle').text(title)
            $('#modal-Verify .vremarks').val('')
            $('#modal-Verify .sBatchID').text(JobID)
            $('#modal-Verify .sJobID').text(JobID)

            $('#modal-Verify .vremarks').val('')
            $('#modal-Verify #vBatchID').val(BatchID)
            $('#modal-Verify #vJobID').val(JobID)

        }