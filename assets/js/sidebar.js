$(function(){
	newcontenttotal()
	notrelevanttotal()


	function newcontenttotal(){
		$.post('sidebar-counts.php', { label : 'newcontent'}, function(result){
			$('.newcontent').text(result)
		})
	}

	function notrelevanttotal(){
		$.post('sidebar-counts.php', { label : 'notrelevant'}, function(result){
			$('.notrelevant').text(result)
		})
	}
})