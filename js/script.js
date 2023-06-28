function selectMode(){

    var value  = document.getElementById("fetchval").value;
    
    $.ajax({
        url:"fetch.php",
        method: "POST",
        data: 'request=' + value,
        
        success:function(data){
            $('#ans').html(data);
        }
    })

}

function fetchDriver(id){
    console.log('in')
    $('#driver').html('');  

    $.ajax({
        method: 'POST',
        url: 'inspect.php',
        data: {mode_id: id},
        success: function(data){
            console.log(data)
            $('#driver').html(data);
        },
        error: function(data){
            
            console.log(data)
        }
    })
}

function fetchDriverE(id){
    console.log('in')
    $('#driver').html('');  

    $.ajax({
        method: 'POST',
        url: 'pen_edit.php',
        data: {mode_id: id},
        success: function(data){
            console.log(data)
            $('#driver').html(data);
        },
        error: function(data){
            
            console.log(data)
        }
    })
}

