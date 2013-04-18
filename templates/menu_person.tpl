{strip}
{if $packageMenuTitle}<a class="dropdown-toggle" data-toggle="dropdown" href="#"> {tr}{$packageMenuTitle}{/tr} <b class="caret"></b></a>{/if}
<ul class="{$packageMenuClass}">
	{if $gBitUser->hasPermission('p_person_view')}
		<li><a class="item" href="{$smarty.const.PERSON_PKG_URL}">{booticon iname="icon-group" iexplain="List People" iforce="icon"}&nbsp;{tr}List&nbsp;People{/tr}</a></li>
	{/if}
	{if $gBitUser->hasPermission('p_person_create')}
		<li><a class="item" href="{$smarty.const.PERSON_PKG_URL}edit.php">{booticon iname="icon-user" iexplain="Create Person Data" iforce="icon"}&nbsp;{tr}Create&nbsp;Person&nbsp;Data{/tr}</a></li>
	{/if}
</ul>
{/strip}
