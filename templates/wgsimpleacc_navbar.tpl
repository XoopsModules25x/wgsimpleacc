<!-- Navigation Startmin Theme-->
<{if $permGlobalView}>
    <nav class="navbar" role="navigation">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <form class="navbar-form" role="search" action="<{xoAppUrl search.php}>" method="get">
                            <div class="form-group">
                                <input type="text" name="query" style='width:75%' class="form-control" placeholder="<{$smarty.const.THEME_SEARCH_TEXT}>"><button class="btn btn-primary" type="submit"><i class="fa fa-search fa-fw"></i></button>
                                <input type="hidden" name="action" value="results">
                            </div>
                        </form>
                    </li>
                    <li>
                        <a href="index.php" class="active"><i class="fa fa-dashboard fa-fw fa-lg"></i> Dashboard</a>
                    </li>
                    <!-- transactions -->
                    <{if $permTransactionsView}>
                        <li>
                            <{if $permTransactionsSubmit}>
                            <a href="#"><i class="fa fa-files-o fa-fw fa-lg"></i></i> <{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS}><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="transactions.php?op=list"><i class="fa fa-list-ol fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_LIST}></a>
                                </li>
                                <li>
                                    <a href="transactions.php?op=new&tra_type=3"><i class="fa fa-plus-square fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_SUBMIT_INCOME}></a>
                                </li>
                                <li>
                                    <a href="transactions.php?op=new&tra_type=2"><i class="fa fa-plus-square fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_SUBMIT_EXPENSE}></a>
                                </li>
                                <{if $permGlobalApprove}>
                                    <li>
                                        <a href="transactions.php?op=listhist"><i class="fa fa-trash fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_TRAHISTORY_DELETED}></a>
                                    </li>
                                <{/if}>
                            </ul>
                            <{else}>
                            <a href="transactions.php"><i class="fa fa-files-o fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_LIST}></a>
                            <{/if}>
                        </li>
                    <{/if}>
                    <!-- Allocations -->
                    <{if $permAllocationsView}>
                        <li>
                            <{if $permAllocationsSubmit}>
                            <a href="#"><i class="fa fa-sitemap fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_ALLOCATIONS}><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="allocations.php?op=list"><i class="fa fa-list-ol fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_ALLOCATIONS_LIST}></a>
                                </li>
                                <li>
                                    <a href="allocations.php?op=new"><i class="fa fa-plus-square fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_ALLOCATION_SUBMIT}></a>
                                </li>
                            </ul>
                            <{else}>
                            <a href="allocations.php?op=list"><i class="fa fa-sitemap fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_ALLOCATIONS_LIST}></a>
                            <{/if}>
                        </li>
                    <{/if}>
                    <!-- Accounts -->
                    <{if $permAccountsView}>
                        <li>
                            <{if $permAccountsSubmit}>
                            <a href="#"><i class="fa fa-table fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_ACCOUNTS}><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="accounts.php?op=list"><i class="fa fa-list-ol fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_ACCOUNTS_LIST}></a>
                                </li>
                                <li>
                                    <a href="accounts.php?op=new"><i class="fa fa-plus-square fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_SUBMIT}></a>
                                </li>
                            </ul>
                            <{else}>
                            <a href="accounts.php?op=list"><i class="fa fa-table fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_ACCOUNTS_LIST}></a>
                            <{/if}>
                        </li>
                    <{/if}>
                    <!-- Assets -->
                    <{if $permAssetsView}>
                        <li>
                            <{if $permAssetsSubmit}>
                            <a href="#"><i class="fa fa-credit-card fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_ASSETS}><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="assets.php?op=list"><i class="fa fa-list-ol fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_ASSETS_LIST}></a>
                                </li>
                                <li>
                                    <a href="assets.php?op=new"><i class="fa fa-plus-square fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_ASSET_SUBMIT}></a>
                                </li>
                            </ul>
                            <{else}>
                            <a href="assets.php?op=list"><i class="fa fa-credit-card fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_ASSETS_LIST}></a>
                            <{/if}>
                        </li>
                    <{/if}>
                    <!-- Templates -->
                    <{if $permTratemplatesView || $permOuttemplatesView}>
                        <li>
                            <a href="#"><i class="fa fa-paste fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_TEMPLATES}><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <{if $permTratemplatesView}>
                                    <li>
                                        <{if $permTratemplatesSubmit}>
                                        <a href="#"><i class="fa fa-paste fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_TRATEMPLATES}><span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <li>
                                                <a href="tratemplates.php?op=list"><i class="fa fa-list-ol fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_TRATEMPLATES_LIST}></a>
                                            </li>
                                            <li>
                                                <a href="tratemplates.php?op=new"><i class="fa fa-plus-square fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_TRATEMPLATE_SUBMIT}></a>
                                            </li>
                                        </ul>
                                        <{else}>
                                        <a href="tratemplates.php?op=list"><i class="fa fa-paste fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_TRATEMPLATES_LIST}></a>
                                        <{/if}>
                                    </li>
                                <{/if}>
                                <{if $permOuttemplatesView}>
                                <li>
                                    <{if $permOuttemplatesSubmit}>
                                        <a href="#"><i class="fa fa-paste fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATES}><span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <li>
                                                <a href="outtemplates.php?op=list"><i class="fa fa-list-ol fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATES_LIST}></a>
                                            </li>
                                            <li>
                                                <a href="outtemplates.php?op=new"><i class="fa fa-plus-square fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATE_SUBMIT}></a>
                                            </li>
                                        </ul>
                                        <{else}>
                                        <a href="outtemplates.php?op=list"><i class="fa fa-paste fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATES_LIST}></a>
                                    <{/if}>
                                </li>
                                <{/if}>
                            </ul>
                        </li>
                    <{/if}>
                    <!-- Balances -->
                    <{if $permBalancesView}>
                        <li>
                            <{if $permBalancesSubmit}>
                            <a href="#"><i class="fa fa-tasks fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_BALANCES}><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="balances.php?op=list"><i class="fa fa-list-ol fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_BALANCES_LIST}></a>
                                </li>
                                <li>
                                    <a href="balances.php?op=new"><i class="fa fa-plus-square fa-fw"></i> <{$smarty.const._MA_WGSIMPLEACC_BALANCE_SUBMIT}></a>
                                </li>
                            </ul>
                            <{else}>
                            <a href="balances.php?op=list"><i class="fa fa-tasks fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_BALANCES_LIST}></a>
                            <{/if}>
                        </li>
                    <{/if}>
                    <!-- Statistics -->
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_STATISTICS}><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <{if $permTransactionsView}>
                                <li>
                                    <a href="statistics.php?op=allocations"><i class="fa fa-sitemap fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_ALLOCATIONS}></a>
                                </li>
                                <li>
                                    <a href="statistics.php?op=assets"><i class="fa fa-credit-card fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_ASSETS}></a>
                                </li>
                                <li>
                                    <a href="statistics.php?op=accounts"><i class="fa fa-table fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_ACCOUNTS}></a>
                                </li>
                            <{/if}>
                            <{if $permBalancesView}>
                                <li>
                                    <a href="statistics.php?op=balances"><i class="fa fa-tasks fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_BALANCES}></a>
                                </li>
                            <{/if}>
                        </ul>
                    </li>
                    <!-- Outputs -->
                    <li>
                        <a href="#"><i class="fa fa-download fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_OUTPUTS}><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <{if $permTransactionsView}>
                                <li>
                                    <a href="outputs.php?op=transactions"><i class="fa fa-files-o fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_LIST}></a>
                                </li>
                                <{foreach item=template from=$outtemplates}>
                                <li>
                                    <a href="outtemplates.php?op=select&amp;otpl_id=<{$template.id}>"><i class="fa fa-files-o fa-fw fa-lg"></i> <{$template.name}></a>
                                </li>
                                <{/foreach}>
                            <{/if}>
                            <{if $permBalancesView}>
                                <li>
                                    <a href="outputs.php?op=balances"><i class="fa fa-tasks fa-fw fa-lg"></i> <{$smarty.const._MA_WGSIMPLEACC_BALANCES}></a>
                                </li>
                            <{/if}>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<{/if}>
