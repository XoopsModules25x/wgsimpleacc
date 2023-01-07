<{if $showList|default:''}>
    <{if $transactionsCount|default:0 > 0}>
        <{if $showItem|default:false}>
            <h3><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DETAILS}></h3>
            <{foreach item=transaction from=$transactions}>
                <{include file='db:wgsimpleacc_transactions_item.tpl' }>
            <{/foreach}>
        <{else}>
            <div class="col-sm-12">
                <a id="toggleFormFilter" class='btn btn-default pull-right' href='#' title='<{$btnfilter}>'><{$btnfilter}></a>
            </div>
            <{if $formFilter|default:''}>
                <div id="formFilter" class="row" style="display:<{$displayfilter|default:''}>">
                    <div class="col-sm-12">
                        <{$formFilter}>
                    </div>
                </div>
            <{/if}>
            <h3><{$listHead|default:''}></h3>
            <div class='table-responsive'>
                <table class='table table-striped'>
                    <thead>
                        <tr>
                            <th scope="col">
                                <{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_YEARNB}>
                                <a class='btn btn-warning btn-xs wgsa-btn-sort' href='transactions.php?op=list&amp;sortby=tra_id&amp;order=asc<{$traOpSorter|default:''}>' title='<{$smarty.const._ASCENDING}>' <{if $sort_order|default:'' == 'tra_id_asc'}>disabled<{/if}>><i class="fa fa-arrow-up fa-fw"></i></a>
                                <a class='btn btn-warning btn-xs wgsa-btn-sort' href='transactions.php?op=list&amp;sortby=tra_id&amp;order=desc<{$traOpSorter|default:''}>' title='<{$smarty.const._DESCENDING}>' <{if $sort_order|default:'' == 'tra_id_desc'}>disabled<{/if}>><i class="fa fa-arrow-down fa-fw"></i></a>
                            </th>
                            <{if $useClients|default:''}>
                                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_CLIID}></th>
                            <{/if}>
                            <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DESC}></th>
                            <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_REFERENCE}></th>
                            <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ACCID}></th>
                            <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ALLID}></th>
                            <th scope="col">
                                <{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DATE}>
                                <a class='btn btn-warning btn-xs wgsa-btn-sort' href='transactions.php?op=list&amp;sortby=tra_date&amp;order=asc<{$traOpSorter|default:''}>' title='<{$smarty.const._ASCENDING}>' <{if $sort_order|default:'' == 'tra_date_asc'}>disabled<{/if}>><i class="fa fa-arrow-up fa-fw"></i></a>
                                <a class='btn btn-warning btn-xs wgsa-btn-sort' href='transactions.php?op=list&amp;sortby=tra_date&amp;order=desc<{$traOpSorter|default:''}>' title='<{$smarty.const._DESCENDING}>' <{if $sort_order|default:'' == 'tra_date_desc'}>disabled<{/if}>><i class="fa fa-arrow-down fa-fw"></i></a>
                            </th>
                            <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNT}></th>
                            <{if $showAssets|default:''}>
                                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ASID}></th>
                            <{/if}>
                            <{if $useTaxes|default:''}>
                                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_TAXID}></th>
                            <{/if}>
                            <{if $useFiles|default:''}>
                                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_FILES}></th>
                            <{/if}>
                            <th scope="col" style="min-width:210px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <{foreach item=transaction from=$transactions}>
                            <{include file='db:wgsimpleacc_transactions_list.tpl' }>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
        <{/if}>
    <{else}>
        <{if $formFilter|default:''}>
            <div id="formFilter" class="row" style="display:<{$displayfilter|default:''}>">
                <div class="col-sm-12">
                    <{$formFilter}>
                </div>
            </div>
        <{/if}>
        <div class="alert alert-danger"><{$noData|default:''}></div>
    <{/if}>
<{/if}>

<{if $showHist|default:''}>
    <h3><{$smarty.const._MA_WGSIMPLEACC_TRAHISTORY_LIST}></h3>
    <div class='table-responsive'>
        <table class='table table-striped'>
            <thead>
            <tr>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_HIST}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_YEARNB}></th>
                <{if $useClients|default:''}>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_CLIID}></th>
                <{/if}>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DESC}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_REMARKS}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_REFERENCE}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ACCID}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ALLID}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DATE}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNT}></th>
                <{if $showAssets|default:''}>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ASID}></th>
                <{/if}>
                <{if $useTaxes|default:''}>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_TAXID}></th>
                <{/if}>
                <{if $useFiles|default:''}>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_FILES}></th>
                <{/if}>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_STATUS}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
            </tr>
            </thead>
            <tbody>
            <{foreach item=transaction from=$historyTransactions}>
                <{include file='db:wgsimpleacc_transactions_hist.tpl' }>
                <{/foreach}>
            </tbody>
            <tfoot>
                <tr>
                    <td class="center" colspan="15">
                        <a class='btn btn-success right' href='javascript:history.back()' title='<{$smarty.const._BACK}>'><{$smarty.const._BACK}></a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
<{/if}>

<!-- Start code for dropdown output -->
<script>
    $(document).ready(function(){
        $("#toggleFormFilter").click(function(){
            $("#formFilter").toggle(1000);
            if (document.getElementById("toggleFormFilter").innerText == "<{$smarty.const._MA_WGSIMPLEACC_FILTER_HIDE}>")
            {
                document.getElementById("toggleFormFilter").innerText = "<{$smarty.const._MA_WGSIMPLEACC_FILTER_SHOW}>";
            }
            else
            {
                document.getElementById("toggleFormFilter").innerText = "<{$smarty.const._MA_WGSIMPLEACC_FILTER_HIDE}>";
            }
        });
    });
    function myDDToggle(id) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if ( dropdowns[i] != document.getElementById(id) ) {
                openDropdown.classList.remove('show');
            }
        }
        document.getElementById(id).classList.toggle("show");
    }
</script>
<style>
    .dropdown-content {
        display: none;
        background-color: #f9f9f9;
        min-width: 50px;
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        z-index: 1;
    }
    .dropdown-content a {
        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
        border-bottom: 1px solid #cccccc;
    }
    .dropdown-content a:hover {
        background-color: #eeeeee;
    }
    .show {
        display: block;
    }
    .dd-down-1 {
        margin:1px 10px 1px 1px;
    }
    .dd-down-2 {
        border-left:1px solid #cccccc;
        margin:0;
        padding:0 10px;
    }
</style>
<!-- End code for dropdown output -->

<!-- Start code for info modal -->
<div class="clear"></div>
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="infoModalLabel">Default Title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="<{$smarty.const._CLOSE}>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><{$smarty.const._CLOSE}></button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#infoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var info = button.data('info');
        var title = button.data('title');
        var modal = $(this);
        modal.find('.modal-title').text(title);
        modal.find('.modal-body').html(info);
    })
</script>
<!-- End code for info modal -->

<!-- Start code for image modal -->
<div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="imgModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="imgModalLabel">Default Title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="<{$smarty.const._CLOSE}>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalimg" class="modal-img" src="" alt="" title="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><{$smarty.const._CLOSE}></button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#imgModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var info = button.data('info');
        var title = button.data('title');
        var modal = $(this);
        modal.find('.modal-title').text(title);
        var modalimg = document.getElementById("modalimg");
        modalimg.src = info;
        var width = modalimg.naturalWidth;
        modal.find(".modal-dialog").css("width", width + 100);
    })
</script>
<!-- End code for image modal -->

<{if $js_autocomplete|default:false}>
    <!-- script for autocomplete select -->
    <!-- https://jqueryui.com/autocomplete/#combobox -->
    <script>
        $( function() {
            $.widget( "custom.combobox", {
                _create: function() {
                    this.wrapper = $( "<div>" )
                        .addClass( "custom-combobox" )
                        .insertAfter( this.element );
                    this.element.hide();
                    this._createAutocomplete();
                    this._createShowAllButton();
                },
                _createAutocomplete: function() {
                    var selected = this.element.children( ":selected" ),
                        value = selected.val() ? selected.text() : "";
                    this.input = $( "<input>" )
                        .appendTo( this.wrapper )
                        .val( value )
                        .attr( "title", "" )
                        .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
                        .autocomplete({
                            delay: 0,
                            minLength: 0,
                            source: $.proxy( this, "_source" )
                        })
                        .tooltip({
                            classes: {
                                "ui-tooltip": "ui-state-highlight"
                            }
                        });
                    this._on( this.input, {
                        autocompleteselect: function( event, ui ) {
                            ui.item.option.selected = true;
                            this._trigger( "select", event, {
                                item: ui.item.option
                            });
                        },
                        autocompletechange: "_removeIfInvalid"
                    });
                },
                _createShowAllButton: function() {
                    var input = this.input,
                        wasOpen = false;
                    $( "<a>" )
                        .attr( "tabIndex", -1 )
                        .attr( "title", "<{$smarty.const._MA_WGSIMPLEACC_CLIENTS_SHOWALL}>" )
                        .tooltip()
                        .appendTo( this.wrapper )
                        .button({
                            icons: {
                                primary: "ui-icon-triangle-1-s"
                            },
                            text: false
                        })
                        .removeClass( "ui-corner-all" )
                        .addClass( "custom-combobox-toggle ui-corner-right" )
                        .on( "mousedown", function() {
                            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
                        })
                        .on( "click", function() {
                            input.trigger( "focus" );
                            // Close if already visible
                            if ( wasOpen ) {
                                return;
                            }
                            // Pass empty string as value to search for, displaying all results
                            input.autocomplete( "search", "" );
                        });
                },
                _source: function( request, response ) {
                    var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                    response( this.element.children( "option" ).map(function() {
                        var text = $( this ).text();
                        if ( this.value && ( !request.term || matcher.test(text) ) )
                            return {
                                label: text,
                                value: text,
                                option: this
                            };
                    }) );
                },
                _removeIfInvalid: function( event, ui ) {
                    // Selected an item, nothing to do
                    if ( ui.item ) {
                        return;
                    }
                    // Search for a match (case-insensitive)
                    var value = this.input.val(),
                        valueLowerCase = value.toLowerCase(),
                        valid = false;
                    this.element.children( "option" ).each(function() {
                        if ( $( this ).text().toLowerCase() === valueLowerCase ) {
                            this.selected = valid = true;
                            return false;
                        }
                    });
                    // Found a match, nothing to do
                    if ( valid ) {
                        return;
                    }
                    // Remove invalid value
                    this.input
                        .val( "" )
                        .attr( "title", "'" + value + "'<{$smarty.const._MA_WGSIMPLEACC_CLIENTS_NOTFOUND}>" )
                        .tooltip( "open" );
                    this.element.val( "" );
                    this._delay(function() {
                        this.input.tooltip( "close" ).attr( "title", "" );
                    }, 2500 );
                    this.input.autocomplete( "instance" ).term = "";
                },
                _destroy: function() {
                    this.wrapper.remove();
                    this.element.show();
                }
            });
            $( "#tra_cliid" ).combobox();
        } );
    </script>
    <!-- End script for autocomplete select -->
<{/if}>

<!-- start calculator -->
<{include file='db:wgsimpleacc_modal_calc.tpl' }>
<!-- end calculator -->
