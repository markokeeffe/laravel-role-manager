 /**
 * General ajax link behavior that submits the link.
 *
 * @param $link The link that will be clicked
 *
 */
MOK.Behaviors.ajaxLink = function($link){

  $link.click(function(){

    $.ajax({
      url: $link.attr('href'),
      success: function (rtn) {
        if (rtn.type === 'success') {
          $($link.data('target')).html(rtn.msg);
          MOK.loadBehaviour($($link.data('target')));
        } else if (rtn.type === 'modal') {
          MOK.Functions.modal(rtn.msg);
        } else if (rtn.match(/<script>/)) {
          $('body').append(rtn);
        }
      }
    });

    return false;
  });

};
