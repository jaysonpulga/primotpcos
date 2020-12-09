
				function ClearFeedbackForm(){
				  	document.getElementById("TypeOfIssue").value="";
		        	document.getElementById("LevelofIssue").value="";
		        	document.getElementById("Description").value="";
		        	 
				}
               function SaveFeedback(){
			        

			      //var jTextArea=document.getElementById("searchJob").value;
			      var BookID= "";

			      var jTextArea = BookID;
			      var data = 'data='+encodeURIComponent(jTextArea)+"&TypeOfIssue="+encodeURIComponent(document.getElementById("TypeOfIssue").value)+"&LevelofIssue="+encodeURIComponent(document.getElementById("LevelofIssue").value)+"&Description="+encodeURIComponent(document.getElementById("Description").value);
			      var xmlhttp = new XMLHttpRequest();
			      xmlhttp.onreadystatechange=function(){
			        if (xmlhttp.readyState==4 && xmlhttp.status==200){
			        	// alert(xmlhttp.responseText);
			        	ClearFeedbackForm();
			            LoadFeedbackList();
			          
			        }
			      }
			      xmlhttp.open("POST","SaveFeedback.php",true);
			            //Must add this request header to XMLHttpRequest request for POST
			      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			      
			      xmlhttp.send(data);
			      
			  }


			  function saveComment(){
			        

			      //var jTextArea=document.getElementById("searchJob").value;
			      var BookID= document.getElementById("FeedbackID").value;
			      var jTextArea = BookID;
			      var data = 'data='+encodeURIComponent(jTextArea)+"&Comment="+encodeURIComponent(document.getElementById("comment").value);
			      var xmlhttp = new XMLHttpRequest();
			      xmlhttp.onreadystatechange=function(){
			        if (xmlhttp.readyState==4 && xmlhttp.status==200){
			        	
			        	 
			            LoadComment(jTextArea);
			            LoadFeedbackList();
			          	document.getElementById("comment").value="";
			        }
			      }
			      xmlhttp.open("POST","SaveComment.php",true);
			            //Must add this request header to XMLHttpRequest request for POST
			      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			      
			      xmlhttp.send(data);
			      
			  }

			   function LoadFeedbackList(){
			        
			      
			      var response=document.getElementById("FeedbackList");
			      //var jTextArea=document.getElementById("searchJob").value;
			      // var BookID= document.getElementById("nBatchID").value;
			      var jTextArea = "";
			      var data = 'data='+encodeURIComponent(jTextArea);
			      var xmlhttp = new XMLHttpRequest();
			      xmlhttp.onreadystatechange=function(){
			        if (xmlhttp.readyState==4 && xmlhttp.status==200){

			          response.innerHTML=xmlhttp.responseText;
			          
			        }
			      }
			      xmlhttp.open("POST","LoadFeedbackList.php",true);
			            //Must add this request header to XMLHttpRequest request for POST
			      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			      
			      xmlhttp.send(data);
			      
			  }
			   function LoadComment(prVal){
			        
			      
			      var response=document.getElementById("chat-box");
			      //var jTextArea=document.getElementById("searchJob").value;
			     
			      var jTextArea = prVal;
			      var data = 'data='+encodeURIComponent(jTextArea);
			      var xmlhttp = new XMLHttpRequest();
			      xmlhttp.onreadystatechange=function(){
			        if (xmlhttp.readyState==4 && xmlhttp.status==200){

			          response.innerHTML=xmlhttp.responseText;
			          document.getElementById("FeedbackID").value=prVal;
			          
			        }
			      }
			      xmlhttp.open("POST","LoadComments.php",true);
			            //Must add this request header to XMLHttpRequest request for POST
			      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			      
			      xmlhttp.send(data);
			      
			  }
			  function DeleteFeedbackRecord(){
		        var jTextArea = document.getElementById("FeedbackID").value;
		       
		        var data = 'data='+encodeURIComponent(jTextArea);
		        var xmlhttp = new XMLHttpRequest();
		        xmlhttp.onreadystatechange=function(){
		          if (xmlhttp.readyState==4 && xmlhttp.status==200){
		             // response.innerHTML=xmlhttp.responseText;
		             // alert(xmlhttp.responseText);
		            LoadFeedbackList();      
		          }
		        }
		        xmlhttp.open("POST","DeleteFeedbackRecord.php",true);
		              //Must add this request header to XMLHttpRequest request for POST
		        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		        
		        xmlhttp.send(data);
		        
		      }

				