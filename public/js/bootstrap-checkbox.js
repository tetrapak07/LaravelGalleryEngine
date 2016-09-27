(function( $ ){
    $.fn.checkbox = function( options ) {
 
        // Create some defaults, extending them with any options that were provided
        var settings = $.extend( {
            'delete_button'         : '.delete_selected',
            'select_all' : 'SelectAll',
            'delete_closure' : function(param){},
            'excluded_click' : ['#actions']
        }, options);
        function toggle_delete_button(){
            if($('tr input[type="checkbox"]:checked').length > 0){
                $(settings.delete_button).removeClass('disabled');
            }else{
                $(settings.delete_button).addClass('disabled');
            }
        }
       $('tr input[type="checkbox"]:not(#'+settings.select_all+'):not(#SelectAllVisible):not(.visible-change):not(.images-visible)').click(function(){
            var state = $(this).prop('checked');
           // console.log(state);
            if (state==true ) state=false; else state=true;
           // if(typeof state != "undefined"){//reverse hack for td click (нельзя помечать по одному)
          /* if(typeof state == "undefined"){//normal mode
                state = null;
            }else{
                state = 'checked';
            }*/
            $(this).prop('checked', state);
            toggle_delete_button();
        });
       /* for (var i in settings.excluded_click){
            $('td:not('+settings.excluded_click[i]+')').click(function(){
                var $this = $('input[type="checkbox"]', $(this).parent());
                  //if(typeof $this.prop('checked') != "undefined"){
                    if(typeof $this.prop('checked') == "undefined"){
                    $this.prop('checked', null);
                }else{
                    $this.prop('checked', 'checked');
                }
                //toggle_delete_button();
            });
        }*/
        $(settings.delete_button).click(function(){
            var selected = new Array();
            $('tr input[type="checkbox"]:not(#'+settings.select_all+'):not(#SelectAllVisible):not(.alboms-visible):not(.visible-change)').each(function(index, elem){
                //if(typeof $(elem).prop('checked') != "undefined"
                if($(elem).prop('checked') && $(elem).attr('id') != settings.select_all
                        && $(elem).attr('class') != 'categories-visible'
                         && $(elem).attr('class') != 'alboms-visible'
                         && $(elem).attr('class') != 'visible-change'
                        ){
               // console.log($(elem).prop('checked'));
                    selected.push($(elem).attr('data-id'));
                }
            });
            if(selected.length > 0){
                selected = selected.join();
                settings.delete_closure(selected);
            }
        });
        $('#'+settings.select_all).click(function(){
            var state = $(this).prop('checked');
            if(state) state = true;
            $('tr input[type="checkbox"]:not(#SelectAllVisible):not(.visible-change):not(.images-visible)').each(function(){
                $(this).prop('checked', state);
            });
          toggle_delete_button();
        });
        return this;
    };
})( jQuery );
    
 $().checkbox({delete_closure : function(selected){
        $('#postvalue').attr('value',selected);
        arr = selected.split(',');
        popped = arr.pop();
        $('.albSel').attr('value',$('#alb'+popped+' :selected').attr('albom-id'));
 }});   

