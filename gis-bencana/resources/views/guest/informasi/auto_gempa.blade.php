<script type="text/javascript">
	// setInterval(()=>{
	// 	auto_gempa()
	// },1000)


	function auto_gempa(){
		$.ajax({
			url:"{{route('informasi.get_auto_gempa')}}",
			success:function(data){
				console.log(data)
			}
		})
	}

	function myFunction(xml){
		console.log(xml)
	}
</script>