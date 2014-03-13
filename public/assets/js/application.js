var MOK = window.MOK || {};

MOK.Behaviors = {};

MOK.Functions = {

  /**
   * Default AJAX Options
   */
  ajaxSetup: function(){
    $.ajaxSetup({
      type: 'POST',
      data: {ajax: 'v'},
      error: function(xhr){
        if(xhr.responseText !== undefined && xhr.responseText !== ''){
          //MOK.Objects.main_modal.generate({heading: 'AJAX Error', body: xhr.responseText});
          console.log(xhr.responseText);
        }
      }
    });
  }

};

/**
 * Run all behaviour functions on elements with 'data-behavior' attributes
 */
MOK.activateBehaviors = function() {
  // Find all elements with the 'data-behavior' attribute
  MOK.behaviors.each(function(){
    var $that = $(this);
    var behaviors = $that.attr('data-behavior');
    $.each(behaviors.split(' '),function(index,behaviorName){
      try{
        // Load the behavior functions and execute
        var BehaviorClass = MOK.Behaviors[behaviorName];
        var initializedBehavior = new BehaviorClass($that);
      } catch(e){
        // No Operation
      }
    });
  });
}

/**
 * Search the DOM for elements using a 'data-behavior' attribute
 * Load the behaviour script files to execute the necessary behaviours
 * and activate the behaviours when the script finishes loading
 *
 * @param context Optional context in which to find elements
 *
 */
MOK.loadBehavior = function(context){

  // Set the default context
  if(context === undefined){
    context = $(document);
  }

  // Find all behaviours within the provided context
  MOK.behaviors = context.find("*[data-behavior]");

  // Run the behavior functions on their attached objects
  MOK.activateBehaviors();

};

// Run the AJAX Setup
MOK.Functions.ajaxSetup();

// Once page has loaded
$(function(){
  // Load all behaviours
  MOK.loadBehavior();
});
