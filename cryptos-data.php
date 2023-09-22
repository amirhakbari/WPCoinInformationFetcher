<?php
/**
* Plugin Name: Cryptos Data
* Description: Show Cryptos Data And Information with API From coinmarketcap.com
*/

function cryptos_data_show_information_with_coin_symbol() {
wp_enqueue_script('cryptos-coin-information', plugin_dir_url(__FILE__).'cryptos-data.js', array('wp-blocks', 'wp-i18n', 'wp-editor'), true, false);
}
add_action('enqueue_block_editor_assets', 'cryptos_data_show_information_with_coin_symbol');

function cryptos_data_javascript() {
    ?>
        <style>
        #coinSymbolName {
            position: relative;
            z-index: 1;
            font-size: 13px;
        }
        #coinSymbolName table {
            width: 100%;
        }

        #coinSymbolName table td, #coinSymbolName table th {
            border: 0.5px solid #ccc;
            padding: 6px;
            text-align: center;
        }

        #coinSymbolName table tr:nth-child(even){
            background-color: #f2f2f2;
        }

        #coinSymbolName table tr:hover {
            background-color: #ddd;
        }

        #coinSymbolName table th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: #822931;
            color: white;
            font-size: 13px;
            text-align: center;
        }

        .wp-block-cryptos-coin-information.isLoading::after {
            content: " ";
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            z-index: 2;
            background-color: rgba(0, 0, 0, 0.22);
        }
        </style>
        <script type="text/javascript">
            window.addEventListener('load', function () {
                let coinSymbolName = document.getElementsByClassName('wp-block-cryptos-coin-information')[0].innerText;
                if(coinSymbolName.length < 1) return;
                let isLoading = true;
                fetch(`https://cors-anywhere.herokuapp.com/https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest?symbol=${coinSymbolName}`, {
                  type: "GET",
                  headers: {
                      'X-CMC_PRO_API_KEY': '30035c9d-d83a-4573-93c5-332a2ce09ccf'
                  }
                })
               .then(resp => resp.json())
               .then((json) => {
               isLoading = false
               const coinSymbolNameUpperCase = coinSymbolName.toUpperCase();
               let propValue = {};
               for(var propName in json.data) {
                   if(json.data.hasOwnProperty(propName)) {
                       propValue = json.data[propName][0];
                   }
               }
               if(propValue.length < 1) return;
                 var myTable =
                       '<table style="border: 1px solid #ccc; width="100%;>' +
                           '<tr>' +
                               '<th>تاریخ عرضه</th>' +
                               '<th>بیشترین عرضه</th>' +
                               '<th>بیشترین مقدار قابل عرضه</th>' +
                               '<th>تغییرات در ۲۴ ساعت</th>' +
                               '<th>قیمت</th>' +
                               '<th>نشانه</th>' +
                               '<th>نام</th>' +
                               '<th>رتبه</th>' +
                           '</tr>' +
                           '<tr>' +
                             `<td>${propValue.date_added.split("T")[0]}</td>` +
                             `<td>${Math.trunc(propValue.total_supply)}</td>` +
                             `<td>${propValue.max_supply}</td>` +
                             `<td>%${propValue.quote.USD.percent_change_24h.toFixed(2) }</td>` +
                             `<td>${propValue.quote.USD.price.toFixed(3) }</td>` +
                             `<td>${propValue.symbol}</td>` +
                             `<td>${propValue.name}</td>` +
                             `<td><b>${propValue.cmc_rank}</b></td>` +
                          '</tr>' +
                          '<tr>' +
                               `<td colspan="3"><a href="https://abantether.com/register?code=M1O4" target="_blank"><b>ثبت نام و ورود</b></a></td>` +
                               `<td colspan="4">صرافی آبان تتر</td>` +
                               `<td colspan="1">#</td>` +
                          '</tr>' +
                          '<tr>' +
                               `<td colspan="3"><a href="https://ramzinex.com/exchange/pt/signup?ref-code=791869" target="_blank"><b>ثبت نام و ورود</b></a></td>` +
                               `<td colspan="4">صرافی رمزینکس</td>` +
                               `<td colspan="1">#</td>` +
                          '</tr>' +
                          '<tr>' +
                              `<td colspan="3"><a href="https://nobitex.ir/signup/?refcode=465413" target="_blank"><b>ثبت نام و ورود</b></a></td>` +
                              `<td colspan="4">صرافی نوبیتکس</td>` +
                              `<td colspan="1">#</td>` +
                          '</tr>' +
                       '</table>';

                       if(myTable.length < 1) return;
                        const parser = new DOMParser();
                        const htmlDoc = parser.parseFromString(myTable, 'text/html').body;
                        const coinHtml = document.getElementById("coinSymbolName");
                        if(isLoading) coinHtml.classList.add('isLoading');
                        if(htmlDoc.childNodes.length < 1) return;
                        coinHtml.append(htmlDoc.childNodes[0]);
                    });
               })
        </script>
    <?php
}
add_action('wp_head', 'cryptos_data_javascript');

?>
