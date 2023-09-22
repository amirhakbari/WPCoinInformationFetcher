wp.blocks.registerBlockType('cryptos/coin-information', {
    title: 'crypto symbol',
    icon: 'money-alt',
    category: 'widgets',
    attributes: {
        symbolName: {
            type: 'string'
        },
    },
    edit: function (props) {
        function updateSymbolName(event){
            props.setAttributes({ symbolName: event.target.value })
        }

        return React.createElement("div", {
            class: "coin-symbol"
        }, React.createElement("label", null, "Coin Symbol:"), /*#__PURE__*/React.createElement("input", {
            type: "text",
            value: props.attributes.symbolName,
            placeholder: "coin symbol",
            onChange: updateSymbolName
        }))
    },
    save: function (props) {
        return /*#__PURE__*/React.createElement("div", {
            id: "coinSymbolName"
        }, props.attributes.symbolName);;
    }
})
