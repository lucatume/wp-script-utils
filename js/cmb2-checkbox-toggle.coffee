(($) ->

    hookBus = window.hookBus = window.hookBus || _.extend {},Backbone.Events

    class RowToggle extends Backbone.View
        @$row: null
        events:
            click: 'toggleTargetVisibility'
        showRow: =>
            @$row.show()
        hideRow: =>
            @$row.hide()
        toggleTargetVisibility: =>
            if @el.checked then @showRow() else @hideRow()
        getTarget: =>
            return @$el.data 'toggle-target'
        initialize: ->
            target = @getTarget()
            targets = target.split(',');
            rows = []
            _.each targets, (selector)->
               rows.push  '.cmb-row.cmb2-id-' + selector
            @$row = $ rows.join ','
            @toggleTargetVisibility()

    class InvertedRowToggle extends RowToggle
        getTarget: =>
            return @$el.data 'invert-toggle-target'
        showRow: =>
            @$row.hide()
        hideRow: =>
            @$row.show()

    # hook in the hookBus to init
    hookBus.on 'initUi:5', ->
        _.each $('input[type="checkbox"][data-toggle-target]'), (el) ->
            new RowToggle
                el: $(el)

        _.each $('input[type="checkbox"][data-invert-toggle-target]'), (el) ->
            new InvertedRowToggle
                el: $(el)
)(jQuery)
