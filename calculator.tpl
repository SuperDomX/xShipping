{include file="~widgets/billboard.tpl"}
<div class="{if !$i.col}col-sm-12{else}{$i.col}{/if} widget">
// Rates for sending a {$data.config[weight]} ".$config[weight_units].", ".$config[size_length]." x ".$config[size_width]." x ".$config[size_height]." {$data.config[size_units]} package from ".$config[from_zip]." to ".$config[to_zip].":
	<xmp>
	{$data.rates|print_r}
	</xmp>
</div>