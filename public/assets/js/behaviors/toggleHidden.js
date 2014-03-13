/**
 * Toggle an elements visiblility when an element is clicked or changed
 *
 * The element can have the following attributes
 * - selector (The selector of the element to toggle)
 * - show (The selector of the element to show)
 * - hide (The selector of the element to hide)
 * - type (Toggle type, i.e. hide, slideToggle etc)
 * - listener (The listener type i.e. click, change)
 * - condition (A regex condition the elements value must match)
 *
 * <a href="#" data-behavior="toggleHidden" data-selector=".campaign-edit">Blah</a>
 *
 * @param $elem The element that triggers the toggle of the selected element
 *
 */
MOK.Behaviors.toggleHidden = function($elem){

  // Get the link text/value
  var text = $elem.text(),
      toggle = ($elem.data('type') ? $elem.data('type') : 'toggle'),
      listener = ($elem.data('listener') ? $elem.data('listener') : 'click'),
      $icon = $elem.find($elem.data('icon')),
      iconClass = $icon.attr('class');

  // When the user clicks the elem, toggle the target element
  // and change the elem text to suit the action e.g. 'Close'
  $elem[listener](function(){

    if ($elem.data('condition')) {
      var val = $elem.val(),
          rex = new RegExp($elem.data('condition'));
      if (val.match(rex)) {
        $($elem.data('selector')).show();
        return false;
      } else {
        $($elem.data('selector')).hide();
        return false;
      }
    }

    if ($elem.data('changeOnVal') && $elem.val() != $elem.data('changeOnVal')) {
      $($elem.data('hide')).hide();
      return false;
    }

    if ($($elem.data('selector')).length) {
      // Toggle the target element
      $($elem.data('selector'))[toggle](function(){
        if ($icon) {
          var toggleClass = $elem.data('iconClass');
          if ($icon.attr('class') == toggleClass) {
            $icon.attr('class', iconClass);
          } else {
            $icon.attr('class', toggleClass);
          }
        }
      });
    }
    if ($($elem.data('show')).length) {
      $($elem.data('show')).show();
    }
    if ($($elem.data('hide')).length) {
      $($elem.data('hide')).hide();
    }

    return false;

  });

}
