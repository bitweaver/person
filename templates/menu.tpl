{strip}
<ul>
	{if $gBitUser->hasPermission('p_person_view')}
		<li><a class="item" href="{$smarty.const.PERSON_PKG_URL}">{biticon ipackage="person" iname="small/list" iexplain="List People" iforce="icon"}&nbsp;{tr}List&nbsp;People{/tr}</a></li>
	{/if}
	{if $gBitUser->hasPermission('p_person_create')}
		<li><a class="item" href="{$smarty.const.PERSON_PKG_URL}edit.php">{biticon ipackage="icons" iname="contact-new" iexplain="Create Person Data" iforce="icon"}&nbsp;{tr}Create&nbsp;Person&nbsp;Data{/tr}</a></li>
	{/if}
</ul>
{/strip}
