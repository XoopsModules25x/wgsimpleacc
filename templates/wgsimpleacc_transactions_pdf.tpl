
<!-- tcpdf does not accept style="padding:10px" -->
<!-- therefore let cellpadding in -->

<table style="width:100%;">
    <tr>
        <td style="width:50%;border-bottom:1px solid #ccc;"><img src="<{$logo.src}>" style="height:<{$logo.height}>"></td>
        <td style="text-align:right;width:50%;border-bottom:1px solid #ccc;"><br><h3><{$header_title}></h3><p><{$header_string}></p></td>
    </tr>
</table>

<table  cellspacing="0" cellpadding="50" border="0" >
    <tr>
        <td><h2 style="text-align:center;"><{$content_header}></h2></td>
    </tr>
</table>

<table  cellspacing="0" cellpadding="10" border="0" >
    <tr>
        <td style="width:30%;border-bottom:1px solid #ccc;"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DESC}>:</td>
        <td style="border-bottom:1px solid #ccc;"><{$transaction.desc}></td>
    </tr>
    <tr>
        <td style="width:30%;border-bottom:1px solid #ccc;"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_REFERENCE}>:</td>
        <td style="border-bottom:1px solid #ccc;"><{$transaction.reference}></td>
    </tr>
    <tr>
        <td style="width:30%;border-bottom:1px solid #ccc;"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ALLID}>:</td>
        <td style="border-bottom:1px solid #ccc;"><{$transaction.allocation}></td>
    </tr>
    <tr>
        <td style="width:30%;border-bottom:1px solid #ccc;"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ACCID}>:</td>
        <td style="border-bottom:1px solid #ccc;"><{$transaction.account}></td>
    </tr>
    <tr>
        <td style="width:30%;border-bottom:1px solid #ccc;"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DATE}>:</td>
        <td style="border-bottom:1px solid #ccc;"><{$transaction.date}></td>
    </tr>
    <{if $useCurrencies}>
    <tr>
        <td style="width:30%;border-bottom:1px solid #ccc;"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_CURID}>:</td>
        <td style="border-bottom:1px solid #ccc;"><{$transaction.curid}></td>
    </tr>
    <{/if}>
    <{if $transaction.amountin > 0}>
    <tr>
        <td><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNTIN}>:</td>
        <td style="border-bottom:1px solid #ccc;"><{$transaction.amountin}></td>
    </tr>
    <{/if}>
    <{if $transaction.amountout > 0}>
    <tr>
        <td style="width:30%;border-bottom:1px solid #ccc;"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNTOUT}>:</td>
        <td style="border-bottom:1px solid #ccc;"><{$transaction.amountout}></td>
    </tr>
    <{/if}>
    <{if $useTaxes}>
    <tr>
        <td><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_TAXID}>:</td>
        <td style="border-bottom:1px solid #ccc;"><{$transaction.taxid}></td>
    </tr>
    <{/if}>
    <tr>
        <td style="width:30%;border-bottom:1px solid #ccc;"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ASID}>:</td>
        <td style="border-bottom:1px solid #ccc;"><{$transaction.asset}></td>
    </tr>
    <tr>
        <td style="width:30%;border-bottom:1px solid #ccc;"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}>:</td>
        <td style="border-bottom:1px solid #ccc;"><{$transaction.datecreated}></td>
    </tr>
    <tr>
        <td style="width:30%;border-bottom:1px solid #ccc;"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}>:</td>
        <td style="border-bottom:1px solid #ccc;"><{$transaction.submitter}></td>
    </tr>
    <tr>
        <td style="width:30%;border-bottom:1px solid #ccc;"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_STATUS}>:</td>
        <td style="border-bottom:1px solid #ccc;"><{$transaction.status_text}></td>
    </tr>
</table>