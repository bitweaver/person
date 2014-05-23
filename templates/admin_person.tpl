{strip}
{form}
	<input type="hidden" name="page" value="{$page}" />
	{jstabs}
		{jstab title="Listing"}
			{legend legend="Person List Field Visibility Settings"}
				{formfields fields=$fields grpname=$grpname}
			{/legend}
		{/jstab}

		<div class="control-group submit">
			<input type="submit" class="btn btn-default" name="{$grpname}_submit" value="{tr}Change preferences{/tr}" />
		</div>
	{/jstabs}
{/form}
{/strip}
