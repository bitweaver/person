<div class="row">
	{formlabel label="Name" for="name_full"}
	{forminput}{$person->getDataShort()}{/forminput}
</div>
<div class="row">
	{formlabel label="Born" for="date_born"}
	{forminput}{$person->getField('date_born')|date_format}{/forminput}
</div>
<div class="row">
	{formlabel label="Email" for="email_verbose"}
	{forminput}{$person->getEmail(TRUE)}{/forminput}
</div>
<div class="row">
	{formlabel label="Phone" for="phone"}
	{forminput}{$person->getPhone(TRUE)}&nbsp;{/forminput}
</div>
