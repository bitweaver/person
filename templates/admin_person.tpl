{strip}
{form}
	{jstabs}
		{jstab title="Listing"}
			{legend legend="Person List Field Visibility Settings"}
				<input type="hidden" name="page" value="{$page}" />
				{foreach from=$formPersonLists key=item item=output}
					<div class="row">
						{formlabel label=`$output.label` for=$item}
						{forminput}
							{html_checkboxes name="$item" values="y" checked=$gBitSystem->getConfig($item) labels=false id=$item}
							{formhelp note=`$output.note` page=`$output.page`}
						{/forminput}
					</div>
				{/foreach}
			{/legend}
		{/jstab}

		<div class="row submit">
			<input type="submit" name="person_settings" value="{tr}Change preferences{/tr}" />
		</div>
	{/jstabs}
{/form}
{/strip}
