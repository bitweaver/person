<div class="row">
	{formlabel label="Name" for="name_full"}
	{forminput}{$person->getDataShort()}{/forminput}
</div>
<div class="row">
	{formlabel label="Born" for="date_born"}
	{forminput}{$person->getField('date_born')|date_format}{/forminput}
</div>
<div class="row">
	{formlabel label="Email" for="email"}
	{forminput}{$person->getEmail(TRUE)}&nbsp;{/forminput}
</div>
<div class="row">
	{formlabel label="Phone" for="phone"}
	{forminput}{$person->getPhone(TRUE)}&nbsp;{/forminput}
</div>
<div class="row">
	{formlabel label="Address" for="address"}
	{forminput}{$person->getAddress(TRUE)}&nbsp;{/forminput}
</div>
