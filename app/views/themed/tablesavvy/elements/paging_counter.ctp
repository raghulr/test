<p class="paging-count">
<?php

if($this->params['named']['type']=='recent')
{
echo $paginator->counter(array(
'format' => 'Page'.' %page% '.'of'.' %pages%, '.' %count% '.' total deals'));
}
else
{
echo $paginator->counter(array(
'format' => 'Page'.' %page% of %pages%, showing %current% records out of %count% total, starting on record %start%' 'ending on %end%'));
}

?></p>