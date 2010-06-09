{* $Header$ *}
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
