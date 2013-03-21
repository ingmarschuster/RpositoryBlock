{if $isArticleView ne 0}
<div class="block" id="sidebarInformation">
    <span class="blockTitle">PID</span>
    {if $pidv2 ne 0}
	{$pidv2}
    {elseif $pidv1 ne 0}
	{$pidv1}
    {else}
	 PID not assigned yet
    {/if}
</div>
<div class="block" id="sidebarInformation">
    <span class="blockTitle">Paper Package</span>
    <div>{$packageName}</div>
    <div><a href="{$rpositoryBase}{$fileName}">(download)</a></div>
</div>
{/if}
