/**
 * Javascript for the Yii EMultiSelect Extension
 *
 * @author David Souto <david.souto@mobgen.com>
 * @date 21-03-2014
 */
(function ($) {

    $.fn.EMultiSelect = function () {
        var $el = this,
            $wrapper = $el.next(".ems-wrapper");

        var $searchAvailable = $wrapper.find(".ems-search-field-available"),
            $searchSelected = $wrapper.find(".ems-search-field-selected");

        var $moveAllLeft = $wrapper.find(".ems-move-all-left"),
            $moveSelLeft = $wrapper.find(".ems-move-sel-left"),
            $moveSelRight = $wrapper.find(".ems-move-sel-right"),
            $moveAllRight = $wrapper.find(".ems-move-all-right");

        var $availableList = $wrapper.find(".ems-available-options"),
            $selectedList = $wrapper.find(".ems-selected-options");

        /**
         * Functions
         */
        var EMultiSelect = {
            refreshAvailableList: function () {
                $availableList.empty();
                $el.find("option:not(:selected)").each(function () {
                    var $option = $(this);
                    var $clone = $option.clone().removeAttr("selected");
                    var optgroup = $option.parent("optgroup").attr("label");
                    if (optgroup) {
                        var $optgroup = $availableList.find("optgroup[label='"+optgroup+"']");
                        if (!$optgroup.length)
                            $optgroup = $("<optgroup></optgroup>").attr("label", optgroup).appendTo($availableList);
                        $clone.appendTo($optgroup)
                    } else {
                        $clone.appendTo($availableList);
                    }
                });
            },
            refreshSelectedList: function () {
                $selectedList.empty();
                $el.find("option:selected").each(function () {
                    var $option = $(this);
                    var $clone = $option.clone().removeAttr("selected");
                    var optgroup = $option.parent("optgroup").attr("label");
                    if (optgroup) {
                        var $optgroup = $selectedList.find("optgroup[label='"+optgroup+"']");
                        if (!$optgroup.length)
                            $optgroup = $("<optgroup></optgroup>").attr("label", optgroup).appendTo($selectedList);
                        $clone.appendTo($optgroup)
                    } else {
                        $clone.appendTo($selectedList);
                    }
                });
            },
            render: function () {
                EMultiSelect.refreshAvailableList();
                EMultiSelect.refreshSelectedList();

                var searchKeyAvailable = $searchAvailable.val();
                if (searchKeyAvailable)
                    EMultiSelect.searchAvailable(searchKeyAvailable);

                var searchKeySelected = $searchSelected.val();
                if (searchKeySelected)
                    EMultiSelect.searchSelected(searchKeySelected);
            },
            selectOption: function ($option) {
                $el.find("option[value=" + $option.attr("value") + "]").attr("selected", "selected");
            },
            deSelectOption: function ($option) {
                $el.find("option[value=" + $option.attr("value") + "]").removeAttr("selected");
            },
            moveAllRight: function () {
                $availableList.find("option").each(function () {
                    EMultiSelect.selectOption( $(this) );
                });
                EMultiSelect.render();
            },
            moveSelRight: function () {
                $availableList.find("option:selected").each(function () {
                    EMultiSelect.selectOption( $(this) );
                });
                EMultiSelect.render();
            },
            moveSelLeft: function () {
                $selectedList.find("option:selected").each(function () {
                    EMultiSelect.deSelectOption( $(this) );
                });
                EMultiSelect.render();
            },
            moveAllLeft: function () {
                $selectedList.find("option").each(function () {
                    EMultiSelect.deSelectOption( $(this) );
                });
                EMultiSelect.render();
            },
            searchAvailable: function (searchKey) {
                $availableList.find("option:not(:icontains(" + searchKey + "))").remove(); //.appendTo($availableList).css('color','red');
            },
            searchSelected: function (searchKey) {
                $selectedList.find("option:not(:icontains(" + searchKey + "))").remove(); //.appendTo($selectedList).css('color','red');
            }
        };

        /**
         * Attach handlers
         */
        $searchAvailable.on('keyup blur', EMultiSelect.render);
        $searchSelected.on('keyup blur', EMultiSelect.render);

        $moveAllLeft.on('click', EMultiSelect.moveAllLeft);
        $moveSelLeft.on('click', EMultiSelect.moveSelLeft);
        $moveSelRight.on('click', EMultiSelect.moveSelRight);
        $moveAllRight.on('click', EMultiSelect.moveAllRight);

        $availableList.on('dblclick', EMultiSelect.moveSelRight);
        $selectedList.on('dblclick', EMultiSelect.moveSelLeft);

        $availableList.on('keypress', function (e) {
            var key = e.which;
            if (key == 13) {
                e.preventDefault();
                EMultiSelect.moveSelRight();
            }
        });
        $selectedList.on('keypress', function (e) {
            var key = e.which;
            if (key == 13) {
                e.preventDefault();
                EMultiSelect.moveSelLeft();
            }
        });

        /**
         * Render the options
         */
        EMultiSelect.render();

        /**
         * Return for chaining
         */
        return this;
    };

    $.expr[':'].icontains = function(a, i, m) {
        return $(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
    };

})(jQuery);