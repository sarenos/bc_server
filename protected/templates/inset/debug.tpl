{*<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />*}
{if $DEBUG_OUTPUT}
<a href="#" id="debug-show" style="position: fixed; right: 0px; top: 10px; border: none;"><img src="{$HTTP_STATIC_PATH}/img/debug.png" alt="debug" width="64" border="0"></a>
<div style="width: 95%; position: fixed; top: 30px; right: 10px; border: thin black solid; background-color: white; z-index: 2000; display:none; padding: 1em; height: 550px; overflow: scroll;" id="debug-block"><div align="right">[<a href="#" class="debug-hide">hide</a>]</div>
{$DEBUG_OUTPUT}<div align="right">[<a href="#" class="debug-hide">hide</a>]</div></div>
{/if}
