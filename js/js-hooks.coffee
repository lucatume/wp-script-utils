(($)->
    hookBus = window.hookBus = window.hookBus || _.extend {}, Backbone.Events

    runHook = (hookName,p) ->
        hook = hookName + ':' + p
        try
            hookBus.trigger hook
        catch error
            message = 'Exception in ' + hook + ' - ' + error.message
            if console then console.log message

    $(document).ready ->
        # 0 to 10 included
        priorities = _.range 11
        runHook 'initBase', p for p in priorities
        runHook 'initFunctional', p for p in priorities
        runHook 'initUi', p for p in priorities
)(jQuery)
