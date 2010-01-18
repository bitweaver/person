{* $Header: /cvsroot/bitweaver/_bit_person/templates/list.tpl,v 1.3 2010/01/18 17:39:21 dansut Exp $ *}
{strip}
{assign var=fwidth value=45}
{assign var=lwidth value=40}
{if $gBitSystem->isFeatureActive('person_list_name_title')}
	{assign var=twidth value=10}
{/if}
{if $gBitSystem->isFeatureActive('person_list_gender')}
	{assign var=gwidth value=15}
{/if}
{if $gBitSystem->isFeatureActive('person_list_description')}
	{assign var=dwidth value=15}
{/if}
<div class="floaticon">
  {bithelp}
	{assign var=iconsize value=$gBitSystem->getConfig("site_icon_size")}
	{biticon ipackage="person" iname="pkg_person" iexplain="person" iclass="$iconsize icon"}
</div>

<div class="listing person">
	<div class="header">
		<h1>{tr}People{/tr}</h1>
	</div>

	<div class="body">

		{form id="checkform"}
			<input type="hidden" name="offset" value="{$control.offset|escape}" />
			<input type="hidden" name="sort_mode" value="{$control.sort_mode|escape}" />

			<table class="data">
				<tr>
					<th width="5%" class="alignright">{smartlink ititle="Id" isort=person_id offset=$control.offset iorder=person_id}</th>
					{if $twidth}<th width="{$twidth}%" class="listleft">{smartlink ititle="Title" isort=name_title offset=$control.offset}</th>{/if}
					<th width="{$fwidth-$twidth-$gwidth}%" class="listleft">{smartlink ititle="First Names" isort=name_1sts offset=$control.offset}</th>
					<th width="{$lwidth-$dwidth}%" class="listleft">{smartlink ititle="Last Name" isort=name_last offset=$control.offset idefault=1}</th>
					{if $gwidth}<th width="{$gwidth}%" class="listleft">{smartlink ititle="Gender" isort=gender offset=$control.offset}</th>{/if}
					{if $dwidth}<th width="{$dwidth}%" class="listleft">{smartlink ititle="Description" isort=title offset=$control.offset}</th>{/if}
					<th width="10%" class="listright">{tr}Actions{/tr}</th>
				</tr>
				{foreach item=person from=$list}
					{assign var=id value=`$person.person_id`}
					<tr class="{cycle values="even,odd"}">
						<td class="alignright"><a href="{$person.display_url}" title="{$id}">{$id}</a></td>
						{if $twidth}<td class="listleft">{$person.name_title|escape}</td>{/if}
						<td class="listleft">{$person.name_1sts|escape}</td>
						<td class="listleft">{$person.name_last|escape}</td>
						{if $gwidth}<td class="listcntr">{$fields.gender.options[$person.gender]}</td>{/if}
						{if $dwidth}<td class="listcntr">{$person.title|escape}</td>{/if}
						<td class="actionicon">
						{if $gBitUser->hasPermission('p_person_update')}
							<a title="{tr}Edit{/tr}" href="{$person.edit_url}">{biticon ipackage="icons" iname="accessories-text-editor" iexplain="Edit Person"}</a>
						{/if}
						</td>
					</tr>
				{foreachelse}
					<tr class="norecords"><td colspan="16">{tr}No records found{/tr}</td></tr>
				{/foreach}
			</table>

		{/form}

		{pagination}
	</div><!-- end .body -->
</div><!-- end .admin -->
{/strip}
