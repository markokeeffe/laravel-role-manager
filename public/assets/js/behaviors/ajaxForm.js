/**
 * Submit a form with AJAX
 *
 * @param $form The form object
 *
 */
MOK.Behaviors.ajaxForm = function ($form) {

  $form.on('submit', function(){

    data = $form.serializeArray();

    data.push({name: 'ajax', value: 'MOK'});

    $.ajax({
      url: $form.attr('action'),
      data: data,
      success: function (rtn) {
        if (rtn.type == 'success') {
        } else if (rtn.type == 'modal') {
          MOK.Functions.modal(rtn.msg);
        } else if (rtn.type == 'validation') {
          $form.html($(rtn.msg).html());
        }
      },
      error: function(xhr){
        if(xhr.responseText !== undefined && xhr.responseText !== ''){
          MOK.Functions.modal({heading: 'Error', body: xhr.responseText});
        }
      }
    });

    return false;
  });

}
