{* $Header: /cvsroot/bitweaver/_bit_person/templates/admin_person.tpl,v 1.2 2010/01/14 21:49:42 dansut Exp $ *}
{strip}
{form}
	<input type="hidden" name="page" value="{$page}" />
	{jstabs}
		{jstab title="Listing"}
			{legend legend="Person List Field Visibility Settings"}
				{formfields fields=$fields grpname=$grpname}
			{/legend}
		{/jstab}

		<div class="row submit">
			<input type="submit" name="{$grpname}_submit" value="{tr}Change preferences{/tr}" />
		</div>
	{/jstabs}
{/form}
{/strip}
