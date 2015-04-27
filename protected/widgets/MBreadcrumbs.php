<?php
Yii::import("zii.widgets.CBreadcrumbs");
class MBreadcrumbs extends CBreadcrumbs
{
    public function run()
    {
        if(empty($this->links))
            return;
        $this->activeLinkTemplate='<a href="{url}" itemprop="url"><span title="{label}" itemprop="title">{label}</span></a>';
        echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
        $links=array();
        if($this->homeLink===null)
            $links[]=CHtml::link(Yii::t('zii','Home'),Yii::app()->homeUrl);
        elseif($this->homeLink!==false)
            $links[]=$this->homeLink;
        foreach($this->links as $label=>$url)
        {
            if(is_string($label) || is_array($url))
                $links[]=strtr($this->activeLinkTemplate,array(
                    '{url}'=>CHtml::normalizeUrl($url),
                    '{label}'=>$this->encodeLabel ? CHtml::encode($label) : $label,
                    '{title}'=>$this->encodeLabel ? CHtml::encode($label) : $label,
                ));
            else
                $links[]=str_replace('{label}',$this->encodeLabel ? CHtml::encode($url) : $url,$this->inactiveLinkTemplate);
        }

        echo '<ul data-tracking-cat="breadcrumbs">';
        $i=0;
        foreach($links as $link){
            if($i>0){
                echo '<li class="separ"><span class="br-arr"></span></li>';
            }
            echo '<li itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb">
                    '.$link.'
                </li>';
            $i++;
        }
        echo "</ul>";
        //echo implode($this->separator,$links);
        echo CHtml::closeTag($this->tagName);
    }
}