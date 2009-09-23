{* $Header: /cvsroot/bitweaver/_bit_person/templates/edit.tpl,v 1.1 2009/09/23 15:20:22 spiderr Exp $ *}
{strip}
<div class="floaticon">
	{bithelp}
	{if $gContent->hasExpungePermission() && $gContent->isValid()}
		<a title="{tr}Remove this Person{/tr}" href="{$smarty.const.PERSON_PKG_URL}remove.php?person_id={$gContent->mInfo.person_id}">{biticon ipackage="icons" iname="edit-delete" iexplain="Remove Person"}</a>
	{/if}
	{assign var=iconsize value=$gBitSystem->getConfig("site_icon_size")}
	{biticon ipackage="person" iname="pkg_person" iexplain="person" iclass="$iconsize icon"}
</div>

<div class="admin person">
	<div class="header">
		<h1>{if $gContent->isValid()}{tr}Edit Person Data{/tr}{else}{tr}Create New Person Data{/tr}{/if}</h1>
	</div>

	<div class="body">
		{form enctype="multipart/form-data" id="editpersonform"}
			{jstabs}
				{jstab title="Person"}
					{legend legend="Personal Details"}
						<input type="hidden" name="person[person_id]" value="{$gContent->mInfo.person_id}" />
						{formfeedback warning=$errors.store}

						{formfields fields=$fields errors=$errors grpname="person"}

						<div class="row">
							{formfeedback warning=$errors.title}
							{formlabel label="Description" for="title"}
							{forminput}
								<input type="text" size="50" name="person[title]" id="title" value="{$gContent->mInfo.title|escape}" />
								{formhelp note="Text that could be useful to help identify the person later."}
							{/forminput}
						</div>

					{/legend}
				{/jstab}

				{jstab title="Notes"}
					{legend legend="Optional expanded details"}
						{textarea name="person[edit]"}{$gContent->mInfo.data}{/textarea}
						{* any simple service edit options *}
						{include file="bitpackage:liberty/edit_services_inc.tpl" serviceFile="content_edit_mini_tpl"}
					{/legend}
				{/jstab}

				{* any service edit template tabs *}
				{include file="bitpackage:liberty/edit_services_inc.tpl" serviceFile="content_edit_tab_tpl"}
			{/jstabs}
			<div class="row submit">
				<input type="submit" name="save_person"
					value="{tr}{if $gContent->mInfo.person_id}Update{else}Create{/if} Person{/tr}" />
			</div>
		{/form}
	</div><!-- end .body -->
</div><!-- end .person -->

{/strip}
