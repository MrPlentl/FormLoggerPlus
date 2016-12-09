/**
 * Created by bplentl on 9/17/2014.
 */

$( document ).ready(function() {
    // Initial Ajax Setup
    $.ajaxSetup({ url: "../lib/ajax_log2file_response.php",  type: "GET" });

    // Log all Text box entries

    $( "input[type=text],[type=tel]" ).blur(function() {
        if($(this).val().length>0){
            if ($(this).attr('id').substring(0, 2) == "X_") {
                $.ajax(
                    {
                        data: {
                            history_log: "User Entry [" + $(this).attr('type') + "] " + add_buffer($(this).attr('type')) + " -> " + "[" + $(this).attr('id') + "]" + " => ** Not Tracking **"
                        }
                    })

            } else if ($(this).attr('id').substring(0, 2) == "CC" || $(this).attr('id').substring(0, 3) == "Acc") {
                $.ajax(
                    {
                        data: {
                            history_log: "User Entry [" + $(this).attr('type') + "] " + add_buffer($(this).attr('type')) + " -> " + "[" + $(this).attr('id') + "]" + " => ****" + $(this).val().slice(-4)
                        }
                    })

            } else {
                $.ajax(
                    {
                        data: {
                            history_log: "User Entry [" + $(this).attr('type') + "] " + add_buffer($(this).attr('type')) + " -> " + "[" + $(this).attr('id') + "]" + " => " + $(this).val()
                        }
                    })
            }
        }
    });


    // Log all Clicks that are not of type text or tel
    $( "input:not( input[type=text], input[type=tel] )" ).change(function(){ if($(this).val().length>0){ $.ajax({ data: {history_log:"User Entry [" + $(this).attr('type') + "] " + add_buffer($(this).attr('type')) + " -> " + "["+$(this).attr('id')+"]" + " => " + $(this).val()}})}});
    // Log all Number Field Clicks
    $( "input[type=button]" ).click(function(){ $.ajax({ data: {history_log:"User Click  -> " + "["+$(this).attr('id')+"]" + " => " + $(this).val()}})});
    // Log all Checkbox Clicks
    //$( "input[type=checkbox]" ).change(function(){ $.ajax({ data: {history_log:"User Select -> " + "["+$(this).attr('id')+"]" + " Checked => " + $(this).prop('checked')}})});
    // Log all Radio Button change
    //$( "input[type=radio]" ).change(function(){$.ajax({data: {history_log:"User Select -> " + "["+$(this).attr('id')+"]" + " Radio Selected => " + $(this).prop('checked')}})});
    // Log all Select Box changes
    $( "select" ).change(function(){ $.ajax({ data: {history_log:"User Entry [select]    -> " + "["+$(this).attr('id')+"]" + " Drop Down Selected => " + $("option:selected", this).text()}})});
    $( "textarea" ).change(function(){ if($(this).val().length>0){ $.ajax({ data: {history_log:"User Entry [textarea]  -> " + "["+$(this).attr('id')+"]" + " => " + $(this).val()}})}});

});

function History(log_data) {
    $.ajax({ data: {history_log:log_data} });
}

function add_buffer(buff){
    var i;
    var buffer="";

    var original_length = buff.length;
    var new_length = 8-original_length;

    for(i=0;i<new_length;i++){
        buffer += " ";
    }

    return buffer;
}