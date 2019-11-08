window.onload=function()
{
	parentdiv=document.getElementsByClassName('taskrow');
	for(i=0; i<parentdiv.length; i++)
		{
			
			checkboxe = parentdiv[i].getElementsByTagName('input')[0];
			checkboxe.addEventListener("click", function(){sendformcheck(event)}, false);
			
		}
	
	function sendformcheck(e){
		value = e.target.value;
		form=document.getElementById('formcheck');
		input = document.getElementById('hidechek').value = value;
		form.submit();
	}
}