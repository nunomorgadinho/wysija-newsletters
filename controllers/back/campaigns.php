<?php
global $viewMedia;
defined('WYSIJA') or die('Restricted access');
class WYSIJA_control_back_campaigns extends WYSIJA_control_back{
    var $model='campaign';
    var $view='campaigns';
    var $list_columns=array('campaign_id','name', 'description');
    var $searchable=array('name', 'description');
    var $filters=array();
    function WYSIJA_control_back_campaigns(){
    }
    
    function welcome_new(){
        $this->title=$this->viewObj->title=__('Welcome Page!',WYSIJA);
        $this->jsTrans['instalwjp']=__('Installing Wysija Newsletter Premium plugin',WYSIJA);
        $hReadme=&WYSIJA::get('readme','helper');
        $hReadme->scan();
        $this->data=array();
        $this->data['abouttext']=__('A Brand New Wysija. Let the Fun Begin.',WYSIJA);
        $mConfig=&WYSIJA::get('config','model');
        $is_multisite=is_multisite();
        $is_network_admin=WYSIJA::current_user_can('manage_network');
        if($is_multisite && $is_network_admin){
            $mConfig->save(array('ms_wysija_whats_new'=>WYSIJA::get_version()));
        }else{
            $mConfig->save(array('wysija_whats_new'=>WYSIJA::get_version()));
        }

        $video_language=array();
        $video_language['en_EN']='http://www.youtube.com/embed/pYzaHDTg5Jk';
        $video_language['fr_FR']='http://www.youtube.com/embed/W5EyW5w7aWQ';
        $video_language['sv_SE']='http://www.youtube.com/embed/O8_t_dekx74';
        $video_language['ar']='http://www.youtube.com/embed/cyDHlX_qgOo';
        if(defined('WPLANG') && WPLANG!='' && isset($video_language[WPLANG])){
            $welcome_video_link=$video_language[WPLANG];
        }else{
            $welcome_video_link=$video_language['en_EN'];
        }
        $this->data['sections'][]=array(
            'title'=>__('First Time? See it in Action',WYSIJA),
            'format'=>'normal',
            'paragraphs'=>array(
                    __('You can start by watching this video by one of our users.',WYSIJA),
                    '<iframe width="853" height="480" src="'.$welcome_video_link.'" frameborder="0" allowfullscreen></iframe>'
                )
            );
        $this->data['sections'][]=array(
                'title'=>__('What You Can Do',WYSIJA),
            	'cols'=>array(
                 array(
                    'title'=>__('5 minute newbie guide',WYSIJA),
                    'content'=>__('Your Wysija comes with an example newsletter. You\'ll see it when you close this welcome page. Edit it to start playing with it.',WYSIJA)
            ),
                array(
                    'title'=>__('Share your data',WYSIJA),
                    'content'=>  str_replace(
                            array('[link]', '[/link]', '[ajaxlink]', '[/ajaxlink]'),
                            array('<a title="Anonymous Data" target="_blank" href="http://support.wysija.com/knowledgebase/share-your-data/">', '</a>', '<a id="share_analytics" href="javascript:;">', '</a>'),
                            __("We know too little about our users. We're looking for [link]anonymous data[/link] to build a better plugin. [ajaxlink]Yes, count me in![/ajaxlink]",WYSIJA))
            ),
                array(
                    'title'=>__('Help yourself. Or let us help you.',WYSIJA),
                    'content'=>  str_replace(
                            array('[link]','[/link]'),
                            array('<a href="http://support.wysija.com/" target="_blank" title="On our blog!">','</a>'),
                            __('We got documentation and a ticket system on [link]support.wysija.com[/link]. We answer within 24h.',WYSIJA))
            )
            ),
            'format'=>'three-col',
        );
        $this->data['sections'][]=array(
            'title'=>__('Wysi... what?',WYSIJA),
            'format'=>'normal',
            'paragraphs'=>array(
            str_replace(
                    array('[link]','[/link]'),
                    array('<a href="http://www.wysija.com/you-want-to-help-us-out/" target="_blank">','</a>'),
                    __('So who are we? We\'re 4 guys who decided in 2011 that WordPress needed a better emailing solution. The tag line <em>What You Send Is Just Awesome</em> was born and the acronym Wysija became our name. If you like what we do, make sure [link]you spread the good word[/link].',WYSIJA))
                )
        );
        $this->viewObj->skip_header=true;
        return true;
    }
    
    function fix_lists(){
        $hUpdate=&WYSIJA::get('update','helper');
        $hUpdate->customerRequestMissingSubscriber();
        exit;
    }

    
    function whats_new(){
        $this->title=$this->viewObj->title=__('What\'s new?',WYSIJA);
        $this->jsTrans['instalwjp']=__('Installing Wysija Newsletter Premium plugin',WYSIJA);
        $helper_readme=&WYSIJA::get('readme','helper');
        $helper_readme->scan();
        $this->data=array();
        $this->data['abouttext']=__('You updated! It\'s like having the next gadget, but better.',WYSIJA);
        $is_multisite=is_multisite();
        $is_network_admin=WYSIJA::current_user_can('manage_network');
        $mConfig=&WYSIJA::get('config','model');
        if($is_multisite){
            if($is_network_admin){
                $mConfig->save(array('ms_wysija_whats_new'=>WYSIJA::get_version()));
            }
        }else{
            $mConfig->save(array('wysija_whats_new'=>WYSIJA::get_version()));
        }

        $major_release=true;
        $except_version=array('2.4.1', '2.4.2');
        $wysija_version=WYSIJA::get_version();
        if(!in_array($wysija_version,$except_version) && count(explode('.', $wysija_version))>2) $major_release=false;
        if($major_release){
           $this->data['sections'][]=array(
                'title'=>__('Added',WYSIJA),
                'cols'=>array(
                	array(
                        'title'=>__('Your data... tada!',WYSIJA),
                        'content'=>  str_replace(
                                array('[link]', '[/link]', '[ajaxlink]', '[/ajaxlink]'),
                                array('<a title="Open in new tab" target="_blank" href="http://support.wysija.com/knowledgebase/share-your-data/">', '</a>', '<a id="share_analytics" href="javascript:;">', '</a>'),
                                __("We're looking for [link]anonymous data[/link] to build a better plugin. [ajaxlink]<strong>Yes, count me in!</strong>[/ajaxlink]",WYSIJA))
                	),
                    array(
                        'title'=>__('Edit the HTML of your text blocks',WYSIJA),
                        'content'=>__('You can now edit the HTML of text blocks in the visual editor. Activate this option in the Settings first.',WYSIJA)
                	),
                    array(
                        'title'=>__('Improving the forms',WYSIJA),
                        'content'=>__('This is a first step in several improvements to the subscription forms. Find your forms in your Settings.',WYSIJA)
                	),
                ),
                'format'=>'three-col',
            );

            $this->data['sections'][]=array(
                'title'=>__('Improved',WYSIJA),
                'cols'=>array(
                    array(
                        'title'=>__('Timely autoresponders',WYSIJA),
                        'content'=>"Send an email to a new subscriber... now works with imported subscribers. Moreover, it works retroactively as well."
                	),
                	array(
                        'title'=>__('In your language',WYSIJA),
                        'content'=>  str_replace(
                                array('[link]', '[/link]'),
                                array('<a title="Open in new tab" target="_blank" href="https://www.transifex.com/projects/p/wysija/">', '</a>'),
                                __('Our translations are getting better. But we\'re always looking for experienced translators. We give out Wysija Premium in exchange. [link]Join the translation teams[/link].',WYSIJA))
                	),
                    array(
                        'title'=>__('Dozen of bug fixes',WYSIJA),
                        'content'=>__('Thanks to all for your feedback. We\'re able to improve our plugin for everybody. Keep it coming.',WYSIJA)
                	)
                ),
                'format'=>'three-col',
            );
        }

        $this->data['sections'][]=array(
            'title'=>__('Keep this plugin essentially free',WYSIJA),
            'review'=>array(
                    'title'=>'1. '.__('Love kittens?',WYSIJA).' '.__('We love stars...',WYSIJA),
                    'content'=>str_replace(
                            array('[link]','[/link]'),
                            array('<a href="http://wordpress.org/support/view/plugin-reviews/wysija-newsletters" target="_blank" title="On wordpress.org">','</a>'),
                            __('Each time one of our users forgets to write a review, a kitten dies. It\'s sad and breaks our hearts. [link]Add your own review[/link] and save a kitten today.',WYSIJA))

                ),
            'follow'=> array(
                    'title'=>'2. '.__('Follow us and don\'t miss anything!',WYSIJA),
                    'content'=>$this->__get_social_buttons(false)
                ),
            'format'=>'review-follow',
        );

        $this->data['sections'][]=array(
            'title'=>'Change log',
            'format'=>'bullets',
            'paragraphs'=>$helper_readme->changelog[WYSIJA::get_version()]
            );

        $this->viewObj->skip_header=true;
        return true;
    }
    

    function licok() {
        parent::WYSIJA_control_back();
        $dt = get_option('wysijey');
        if(isset($_REQUEST['xtz']) && $dt === $_REQUEST['xtz']){
            $dataconf = array('premium_key'=> base64_encode(get_option('home').time()), 'premium_val' => time());
            $this->notice(__('Premium version is valid for your site.',WYSIJA));
        } else {
            $dataconf = array('premium_key' => '', 'premium_val' => '');
            $helper_licence=&WYSIJA::get('licence','helper');
            $url_premium = 'http://www.wysija.com/checkout/?wysijadomain='.$dt.'&nc=1&utm_source=wpadmin&utm_campaign=error_licence_activation';
            $this->error(str_replace(array('[link]','[/link]'),array('<a href="'.$url_premium.'" target="_blank">','</a>'),
            __('Premium licence does not exist for your site. Purchase it [link]here[/link].',WYSIJA)), 1);
        }
        WYSIJA::update_option('wysicheck',false);
        $modelConf=&WYSIJA::get('config','model');
        $modelConf->save($dataconf);
        $this->redirect('admin.php?page=wysija_config#tab-premium');
    }
    
    function validateLic(){
        $helpLic=&WYSIJA::get('licence','helper');
        $res = $helpLic->check();
        $this->redirect();
    }
    
    function manual_send($dataPost=false){
        $modelQ=&WYSIJA::get('queue','model');
        $config=&WYSIJA::get('config','model');
        if((int)$config->getValue('total_subscribers')<2000  ){
            if($modelQ->count()>0){
                $helperQ=&WYSIJA::get('queue','helper');
                $emailid=false;
                if($_REQUEST['emailid']){
                    $emailid=$_REQUEST['emailid'];
                }
                $helperQ->process($emailid);
            }else{
                echo '<strong style="font-family: Arial; font-weight: bold; font-size: 12px;">'.__('Queue is empty!',WYSIJA).'</strong>';
            }
            exit;
        }else {

            do_action('wysija_send_test_editor');
            do_action('wysija_manual_send');
        }
        exit;
    }
    
    function test(){
        @ini_set('max_execution_time',0);
        $config = &WYSIJA::get('config','model');
        $bounceClass = &WYSIJA::get('bounce','helper');
        $bounceClass->report = true;
        if(!$bounceClass->init()){
                $res['result']=false;
                return $res;
        }
        if(!$bounceClass->connect()){
                $this->error($bounceClass->getErrors());
                $res['result']=false;
                return $res;
        }
        $this->notice(sprintf(__('Successfully connected to %1$s',WYSIJA),$config->getValue('bounce_login')));
        $nbMessages = $bounceClass->getNBMessages();

        if(empty($nbMessages)){
            $this->error(__('There are no messages',WYSIJA),true);
            $res['result']=false;
            return $res;
        }else{
            $this->notice(sprintf(__('There are %1$s messages in your mailbox',WYSIJA),$nbMessages));
        }

        $bounceClass->handleMessages();
        $bounceClass->close();
        exit;
        return true;
    }
    function add($dataPost=false){
        $this->title=sprintf(__('Step %1$s',WYSIJA),1);
        $this->js[]='wysija-validator';
        $this->js[]='wysija-edit-autonl';
        $this->js['admin-campaigns-edit']='admin-campaigns-edit';
        $this->jsTrans['descauto']=str_replace(array('[newsletter:number]','[newsletter:total]','[newsletter:post_title]'),array('<b>[newsletter:number]</b>','<b>[newsletter:total]</b>','<b>[newsletter:post_title]</b>'),__('Insert [newsletter:total] to show number of posts, [newsletter:post_title] to show the latest post\'s title & [newsletter:number] to display the issue number.',WYSIJA));
        $this->jsTrans['descstandard']=__('The first thing your subscribers see. Be creative and increase your open rate!',WYSIJA);
        $this->immediateWarning();
        $this->viewObj->title=__('First step: main details',WYSIJA);
        $this->viewShow='add';
        $this->data=array();
        $this->data['campaign']=array('name'=>'','description'=>'');
        $modelConfig=&WYSIJA::get('config','model');
        $this->data['email']=array('subject'=>'','from_email'=>$modelConfig->getValue('from_email'),'from_name'=>$modelConfig->getValue('from_name'));
        $this->data['lists']=$this->__getLists(false,true,true);
        $this->dataAutoNl();
        $this->jsLoc['admin-campaigns-edit']['autofields']=$this->data['autonl']['fields'];
    }
    
    function dataAutoNl(){
        $dataFrequencyNoImmediate=$dataFrequency=array('daily'=>__('once a day at...',WYSIJA),
                    'weekly'=>__('weekly on...',WYSIJA),
                    'monthly'=>__('monthly on the...',WYSIJA),
                    'monthlyevery'=>__('monthly every...',WYSIJA),
            'immediate'=>__('immediately.',WYSIJA));
        unset($dataFrequencyNoImmediate['immediate']);
        $times = array();
        $time = strtotime('00:00:00');
        $toolboxH=&WYSIJA::get('toolbox','helper');
        $times['00:00:00']=$toolboxH->localtime($time);
        for($i = 1;$i < 24;$i++) {
            $time = strtotime('+ 1hour',$time);
            $key = date('H:i:s',$time);
            $times[$key] = $toolboxH->localtime($time);
        }
        $daysvalues=$toolboxH->getday();
        $numberweeks=$toolboxH->getweeksnumber();
        $daynumbers=$toolboxH->getdaynumber();

        $dataLists=array();
        foreach($this->data['lists'] as $datal)    {
            if($datal['is_enabled'])    $dataLists[$datal['list_id']]=$datal['name'];
        }

        $wptoolsH =& WYSIJA::get('wp_tools','helper');
        $roles = $wptoolsH->wp_get_all_roles();
        $available_roles = array('any'=>__('in any role,',WYSIJA));
        foreach ($roles as $role => $name) {
            $available_roles[$role] = __('as ' . $name . ',',WYSIJA);
        }
        $this->data['autonl']['fields']=array(
            'event'=>array(
                'values'=>array(
                    'new-articles'=>__('there\'s new content, send...',WYSIJA),
                    'subs-2-nl'=>__('someone subscribes to the list...',WYSIJA),
                    'new-user'=>__('a new WordPress user is added to your site...',WYSIJA),
                    ),
                'valueshow'=>array(
                    'new-articles'=>array('when-article'),
                    'subs-2-nl'=>array('subscribetolist','numberafter','numberofwhat','unique_send'),
                    'new-user'=>array('roles','numberafter','numberofwhat','unique_send'),
                    ),
                'style'=>'width:300px;'
                ),
            'when-article'=>array(
                'values'=>$dataFrequency,
                'valueshow'=>array(
                    'daily'=>array('time'),
                    'weekly'=>array('dayname','time'),
                    'monthly'=>array('daynumber','time'),
                    'monthlyevery'=>array('dayevery','dayname','time'),
                    )
                ),
            'subscribetolist'=>array(
                'values'=>$dataLists,
                'style'=>'width:300px;'
                ),
            'roles'=>array(
                'values'=>$available_roles
            ),
            'numberafter'=>array(
                'type'=>'input',
                'style'=>'width:35px;',
                'class'=>'validate[required,custom[integer],min[1]]',
                ),
            'numberofwhat'=>array(
                'values'=>array(
                    'immediate'=>__('immediately.',WYSIJA),
                    'hours'=>__('hour(s) after.',WYSIJA),
                    'days'=>__('day(s) after.',WYSIJA),
                    'weeks'=>__('week(s) after.',WYSIJA)
                    ),
                'valuesunit'=>array(
                    'immediate'=>__('immediately',WYSIJA),
                    'hours'=>__('hour(s)',WYSIJA),
                    'days'=>__('day(s)',WYSIJA),
                    'weeks'=>__('week(s)',WYSIJA)
                    ),
                ),
            'dayevery'=>array(
                'values'=>$numberweeks,
                ),
            'dayname'=>array(
                'values'=>$daysvalues,
                ),
            'daynumber'=>array(
                'values'=>$daynumbers,
                ),
            'time'=>array(
                'values'=>$times,
                ),
            
        );
        $helpersEvent=&WYSIJA::get('autonews','helper');
        $extraEvents=$helpersEvent->events();
        
        if($extraEvents){
            foreach($extraEvents as $k =>$v){
                $this->data['autonl']['fields']['event']['values'][$k]=$v['title'];
                foreach($v['fields'] as $fieldCKEY => $fieldCVAL){
                    if(isset($this->data['autonl']['fields'][$fieldCKEY]))  continue;
                }
                $this->data['autonl']['fields']['event']['valueshow'][$k]=array_keys($v['fields']);
            }
        }
    }

    function __getLists($enabled=true,$count=false,$notgetalllistid=false){
        $modelList=&WYSIJA::get('list','model');

        if($enabled) $enabledstrg=' is_enabled>0 and';
        else $enabledstrg='';
        $extrasql='';
        if(!$notgetalllistid) $extrasql='WHERE  list_id in (SELECT distinct(list_id) from wp_wysija_user_list )';
        $query='SELECT * FROM [wysija]list '.$extrasql;
        $listres=$modelList->query('get_res',$query);
        if($count){
          $mConfig =& WYSIJA::get('config','model');
          $condit = '>=';
          if($mConfig->getValue('confirm_dbleoptin')) $condit='>';
          $qry1="SELECT count(distinct A.user_id) as nbsub,A.list_id FROM `[wysija]user_list` as A LEFT JOIN `[wysija]user` as B on A.user_id=B.user_id WHERE B.status $condit 0 and A.sub_date>0 and A.unsub_date=0 GROUP BY list_id";
          $total=$modelList->getResults($qry1);
            foreach($total as $tot){
                foreach($listres as $key=>$res){
                    if($tot['list_id']==$res['list_id']) $listres[$key]['count']=$tot['nbsub'];
                }
            }
        }
        foreach($listres as $key =>$res){
            if(!isset($res['count']))   $listres[$key]['count']=0;
        }
        return $listres;
    }
    function edit($dataPost=false){
        if(!$this->_checkEmailExists($_REQUEST['id'])) return;
        $this->add();
        $modelEmail=&WYSIJA::get('email','model');
        $this->data['email']=$modelEmail->getOne(false,array('email_id'=>$_REQUEST['id']));
        if($this->data['email']['status']>0){
            $this->redirect();
        }
        $this->title=sprintf(__('Step %1$s',WYSIJA),1).' | '.$this->data['email']['subject'];
        $modelCamp=&WYSIJA::get('campaign','model');
        $this->data['campaign']=$modelCamp->getOne(false,array('campaign_id'=>$this->data['email']['campaign_id']));
        $modelCL=&WYSIJA::get('campaign_list','model');
        $this->data['campaign_list']=$modelCL->get(false,array('campaign_id'=>$this->data['email']['campaign_id']));
    }

    function editTemplate(){

        header('Cache-Control: no-cache, max-age=0, must-revalidate, no-store'); // HTTP/1.1
        header('Expires: Fri, 9 Mar 1984 00:00:00 GMT');
        if(!$this->_checkEmailExists($_REQUEST['id'])) return;
        $this->viewShow = 'editTemplate';
        wp_enqueue_style('thickbox');
        $wjEngine =& WYSIJA::get('wj_engine', 'helper');
        
        $this->jsTrans = array_merge($this->jsTrans, $wjEngine->getTranslations());
        $this->jsTrans['savingnl']=__('Saving newsletter...',WYSIJA);
        $this->jsTrans['errorsavingnl']=__('Error Saving newsletter...',WYSIJA);
        $this->jsTrans['savednl']=__('Newsletter has been saved.',WYSIJA);
        $this->jsTrans['previewemail']=__('Sending preview...',WYSIJA);
        $this->jsTrans['spamtestresult']=__('Spam test results',WYSIJA);
        
        $this->js[]='wysija-editor';
        $this->js[]='wysija-admin-ajax-proto';
        $this->js[]='wysija-admin-ajax';
        $this->js[]='wysija-base-script-64';
        $this->js[]='media-upload';
        $this->js['admin-campaigns-editDetails']='admin-campaigns-editDetails';
        $modelEmail=&WYSIJA::get('email','model');
        $this->data=array();
        $this->data['email']=$modelEmail->getOne(false,array('email_id'=>$_REQUEST['id']));
        $this->checkIsEditable();
        $this->viewObj->title=sprintf(__('Second step :  "%1$s"',WYSIJA),$this->data['email']['subject']);
        $this->title=sprintf(__('Step %1$s',WYSIJA),2)." | ".$this->data['email']['subject'];

        $model_config =& WYSIJA::get('config', 'model');
        $this->jsTrans['html_source_enabled'] = (int)$model_config->getValue('html_source');
    }
    function checkIsEditable(){
        if(
                !($this->data['email']==2 || isset($this->data['email']['params']['schedule']['isscheduled']))
                        && $this->data['email']['status']>0
                        ){
            $this->redirect();
        }
    }
    function pause(){
        
        if(isset($_REQUEST['id']) && $_REQUEST['id']){
            $modelEmail=&WYSIJA::get('email','model');
            $myemail=$modelEmail->getOne(false,array('email_id'=>$_REQUEST['id']));
            $modelEmail->reset();
            $modelEmail->columns['modified_at']['autoup']=1;
            $modelEmail->update(array('status'=>-1),array('email_id'=>$_REQUEST['id']));
            if($myemail['type']==2){
                return $this->redirect('admin.php?page=wysija_campaigns&id='.$myemail['email_id'].'&action=edit');
            }else{
                $this->notice(__('Sending is now paused.',WYSIJA));
            }
        }
        $this->redirect();
    }
    function resume(){
        
        if(isset($_REQUEST['id']) && $_REQUEST['id']){
            $modelEmail=&WYSIJA::get('email','model');
            $modelEmail->columns['modified_at']['autoup']=1;
            $modelEmail->update(array('status'=>99),array('email_id'=>$_REQUEST['id']));
            $this->notice(__('Sending has resumed.',WYSIJA));
        }
        $this->redirect();
    }
    function duplicate(){
        
        $model=&WYSIJA::get('campaign','model');
        $query='INSERT INTO `[wysija]campaign` (`name`,`description`)
            SELECT concat("'.stripslashes(__('Copy of ',WYSIJA)).'",`name`),`description` FROM [wysija]campaign
            WHERE campaign_id='.(int)$_REQUEST['id'];
        $campaignid=$model->query($query);
        
        $query='INSERT INTO `[wysija]email` (`campaign_id`,`subject`,`body`,`type`,`params`,`wj_data`,`wj_styles`,`from_email`,`from_name`,`replyto_email`,`replyto_name`,`attachments`,`status`,`created_at`,`modified_at`)
            SELECT '.$campaignid.', concat("'.stripslashes(__('Copy of ',WYSIJA)).'",`subject`),`body`,`type`,`params`,`wj_data`,`wj_styles`,`from_email`,`from_name`,`replyto_email`,`replyto_name`,`attachments`,0,'.time().','.time().' FROM [wysija]email
            WHERE email_id='.(int)$_REQUEST['email_id'];
        $emailid=$model->query($query);

        $mEmail=&WYSIJA::get('email','model');
        $emailData=$mEmail->getOne(false,array('email_id'=>$emailid));
        if($emailData['type']==2){
            $paramsReseted=$emailData['params'];
            if(isset($paramsReseted['autonl']['total_child']))  $paramsReseted['autonl']['total_child']=0;
            if(isset($paramsReseted['autonl']['nextSend']))  $paramsReseted['autonl']['nextSend']=0;
            if(isset($paramsReseted['autonl']['firstSend']))  unset($paramsReseted['autonl']['firstSend']);
            if(isset($paramsReseted['autonl']['lastSend']))  unset($paramsReseted['autonl']['lastSend']);
            if(isset($paramsReseted['autonl']['articles']['ids']))  unset($paramsReseted['autonl']['articles']['ids']);

            $mEmail->update(array('params'=>$paramsReseted),array('email_id'=>$emailid));
        }
        
        $query="INSERT INTO `[wysija]campaign_list` (`campaign_id`,`list_id`,`filter`)
            SELECT $campaignid,`list_id`,`filter` FROM [wysija]campaign_list
            WHERE campaign_id=".(int)$_REQUEST['id'];
        $model->query($query);
        $this->notice(__('The newsletter has been duplicated.',WYSIJA));
        $this->redirect('admin.php?page=wysija_campaigns&id='.$emailid.'&action=edit');
    }
    function duplicateEmail(){
        if(!$this->_checkEmailExists($_REQUEST['id'])) return;
        $model=&WYSIJA::get('campaign','model');
        
        $query='INSERT INTO `[wysija]email` (`campaign_id`,`subject`,`body`,`params`,`wj_data`,`wj_styles`,`from_email`,`from_name`,`replyto_email`,`replyto_name`,`attachments`,`status`,`created_at`,`modified_at`)
            SELECT `campaign_id`, concat("'.stripslashes(__("Copy of ",WYSIJA)).'",`subject`),`body`,`params`,`wj_data`,`wj_styles`,`from_email`,`from_name`,`replyto_email`,`replyto_name`,`attachments`,0,'.time().','.time().' FROM [wysija]email
            WHERE email_id='.(int)$_REQUEST['id'];
        $emailid = $model->query($query);
        $this->notice(__('The newsletter has been duplicated.',WYSIJA));
        $this->redirect('admin.php?page=wysija_campaigns&id='.$emailid.'&action=edit');
    }
    function immediateWarning(){
        $mConfig=&WYSIJA::get('config','model');
        $is_multisite=is_multisite();

        if($is_multisite && $mConfig->getValue('sending_method')=='network'){
           $sending_emails_each=$mConfig->getValue('ms_sending_emails_each');
           $number=$mConfig->getValue('ms_sending_emails_number');
        }else{
           $sending_emails_each=$mConfig->getValue('sending_emails_each');
           $number=$mConfig->getValue('sending_emails_number');
        }
        $formsHelp=&WYSIJA::get('forms','helper');
        $timespan=$formsHelp->eachValuesSec[$sending_emails_each];
        $tb=&WYSIJA::get('toolbox','helper');
        $this->immediatewarning=str_replace(
                array('[link]','[/link]','[settings]'),
                array('<a href="#">','</a>',sprintf(__('%1$s emails every %2$s',WYSIJA),$number,trim($tb->duration($timespan,true)))),
                __('Your sending settings ([settings]) can\'t send that quickly to [number] subscribers. Expect delivery delays. [link]Read more[/link]',WYSIJA));
        $this->viewObj->immediatewarning='<span class="warning-msg" id="immediatewarning">'.$this->immediatewarning.'</span>';
        $this->jsTrans['immediatewarning']=$this->immediatewarning;


        if($timespan < 43200){
            $ratio=floor(43200/$timespan);
            $this->jsTrans['possibleemails']=$ratio*$number;
        }else{
            if($timespan == 43200){
                $this->jsTrans['possibleemails']=$number;
            }else{
                $ratio=floor($timespan/43200);
                $this->jsTrans['possibleemails']=$number/$ratio;
            }
        }
    }
    function editDetails(){
        if(!$this->_checkEmailExists($_REQUEST['id'])) return;
        $this->viewObj->title=__('Final step : last details',WYSIJA);
        $this->viewShow='editDetails';
        $this->js[]='wysija-validator';
        $this->jsTrans['previewemail']=__('Sending preview...',WYSIJA);
        $this->jsTrans['pickadate']=__('Pick a date',WYSIJA);
        $this->jsTrans['saveclose']=__('Save & close',WYSIJA);
        $this->jsTrans['sendlater']=__('Send later',WYSIJA);
        $this->jsTrans['schedule']=__('Schedule',WYSIJA);

        $this->js[]='jquery-ui-datepicker';
        $modelList=&WYSIJA::get('list','model');
        $modelList->limitON=false;
        $this->data=array();
        $this->data['lists']=$this->__getLists(false,true,true);
        $modelEmail=&WYSIJA::get('email','model');
        $this->data['email']=$modelEmail->getOne(false,array('email_id'=>$_REQUEST['id']));
        if((int)$this->data['email']['type']==2){
            $this->js['wysija-edit-autonl']='wysija-edit-autonl';
            $this->jsTrans['autonl']=true;
            $this->immediateWarning();
            $this->jsTrans['send']=__('Activate now',WYSIJA);
        }else{
            $this->jsTrans['autonl']=true;
            $this->viewObj->immediatewarning='';
            $this->jsTrans['send']= __('Send',WYSIJA);
        }
        if((int)$this->data['email']['type']==1){
            $this->jsTrans['alertsend']=__('You are about to send this newsletter. Please confirm.',WYSIJA);
        }

        $this->checkIsEditable();
        $this->title=sprintf(__('Step %1$s',WYSIJA),3)." | ".$this->data['email']['subject'];
        $this->dataAutoNl();
        $this->jsLoc['wysija-edit-autonl']['autofields']=$this->data['autonl']['fields'];
        $modelCL=&WYSIJA::get('campaign_list','model');
        $this->data['campaign_list']=$modelCL->get(false,array('campaign_id'=>$this->data['email']['campaign_id']));

    }
    function delete(){
        $this->requireSecurity();
        if(isset($_REQUEST['id'])){
            $modelCampaign=&WYSIJA::get('campaign','model');
            $modelCampaign->delete(array('campaign_id'=>$_REQUEST['id']));
            $modelCampaignL=&WYSIJA::get('campaign_list','model');
            $modelCampaignL->delete(array('campaign_id'=>$_REQUEST['id']));
            $modelEmail=&WYSIJA::get('email','model');
            $modelEmail->delete(array('campaign_id'=>$_REQUEST['id']));
            $this->notice(__('Newsletter deleted.',WYSIJA));
        }else{
            $this->notice(__("Newsletter can't be deleted.",WYSIJA));
        }
        $this->redirect();
    }
    function deleteEmail(){
        $this->requireSecurity();
        if(!$this->_checkEmailExists($_REQUEST['id'])) return;
        if(isset($_REQUEST['id'])){
            $modelEmail=&WYSIJA::get('email','model');
            $modelEmail->delete(array('email_id'=>$_REQUEST['id']));
            $this->notice(__('Newsletter deleted.',WYSIJA));
        }else{
            $this->notice(__('Newsletter can\'t be deleted.',WYSIJA));
        }
        $this->redirect();
    }
     function savecamp(){
        $this->redirectAfterSave=false;


        
        $data=array();
        if(isset($_REQUEST['id'])){
            $modelEmail=&WYSIJA::get('email','model');
            $modelEmail->fieldValid=false;
            $emaildataarr=$modelEmail->getOne(array('email_id'=>$_REQUEST['id']));
            $modelCampaign=&WYSIJA::get('campaign','model');
            $modelCampaign->update(array('name'=>$_POST['wysija']['email']['subject'],'description'=>''),array('campaign_id'=>$emaildataarr['campaign_id']));
            $campaign_id=$emaildataarr['campaign_id'];
            $email_id=$emaildataarr['email_id'];
            $dataEmail=array(
                'campaign_id'=>$campaign_id,
                'subject'=>$_POST['wysija']['email']['subject'],
                'type'=>$_POST['wysija']['email']['type']);
            if((int)$dataEmail['type'] === 2){

                $newparams['autonl']=$_POST['wysija']['email']['params']['autonl'];
                $dataEmail['params']=$newparams;
                if(!isset($newparams['autonl']['unique_send'])){
                    unset($dataEmail['params']['autonl']['unique_send']);
                }else $dataEmail['params']['autonl']['unique_send']=true;
            }
            $modelEmail->columns['modified_at']['autoup']=1;
            $modelEmail->debugupdate=true;
            $dataEmail['email_id']=$_REQUEST['id'];
            if(isset($_REQUEST['save-reactivate'])){

                $dataEmail['status']=99;
                $_REQUEST['return']=1;
            }
            $data['email']['email_id']=$modelEmail->update($dataEmail,array('email_id'=>$_REQUEST['id']));
        } else {
            $modelCampaign=&WYSIJA::get('campaign','model');
            $campaign_id = $modelCampaign->insert(array('name' => $_POST['wysija']['email']['subject'], 'description' => ''));
            $modelEmail=&WYSIJA::get('email','model');
            $modelEmail->fieldValid=false;
            $emaildata=array(
                'campaign_id' => $campaign_id,
                'subject' => $_POST['wysija']['email']['subject'],
                'type' => (int)$_POST['wysija']['email']['type']
            );


            if((int)$_POST['wysija']['email']['type'] === 2 && isset($_POST['wysija']['email']['params']['autonl'])) {
                $emaildata['params'] = array('autonl' => $_POST['wysija']['email']['params']['autonl']);
            }

            if((int)$_POST['wysija']['email']['type'] === 2 && $_POST['wysija']['email']['params']['autonl']['event'] === 'new-articles') {

                if($emaildata['params']['autonl']['when-article'] === 'immediate') {
                    $autopostParams = array(
                        array('key' => 'category_ids', 'value' => ''),
                        array('key' => 'category', 'value' => ''),
                        array('key' => 'title_tag', 'value' => 'h2'),
                        array('key' => 'title_alignment', 'value' => 'left'),
                        array('key' => 'image_alignment', 'value' => 'alternate'),
                        array('key' => 'post_content', 'value' => 'excerpt'),
                        array('key' => 'readmore', 'value' => base64_encode(__('Read online.',WYSIJA))),
                        array('key' => 'show_divider', 'value' => 'yes'),
                        array('key' => 'cpt', 'value' => 'post'),
                        array('key' => 'post_limit', 'value' => 1)
                    );
                } else {
                    $autopostParams = array(
                        array('key' => 'category_ids', 'value' => ''),
                        array('key' => 'category', 'value' => ''),
                        array('key' => 'title_tag', 'value' => 'h2'),
                        array('key' => 'title_alignment', 'value' => 'left'),
                        array('key' => 'image_alignment', 'value' => 'alternate'),
                        array('key' => 'post_content', 'value' => 'excerpt'),
                        array('key' => 'readmore', 'value' => base64_encode(__('Read online.',WYSIJA))),
                        array('key' => 'show_divider', 'value' => 'yes'),
                        array('key' => 'cpt', 'value' => 'post'),
                        array('key' => 'post_limit', 'value' => 2)
                    );
                }

                $newwjdata = array(
                    'version' => WYSIJA::get_version(),
                    'header' => array(
                        'text' => NULL,
                        'image' => array(
                            'src' => WYSIJA_EDITOR_IMG.'transparent.png',
                            'width' => 600,
                            'height' => 86,
                            'alignment' => 'center',
                            'static' => true,
                        ),
                        'alignment' => 'center',
                        'static' => true,
                        'type' => 'header'
                    ),
                    'body' => array(
                        'block-1' => array(
                            'text' => array(
                                'value' => '<h3 class="align-right">'.sprintf(__("The posts below were added with the widget %sAutomatic latest content%s", WYSIJA), '<strong>', '</strong>').'</h3>'
                            ),
                            'image' => array(
                                'src' => WYSIJA_EDITOR_IMG.'default-newsletter/autonewsletter/arrow-up.png',
                                'width' => 45,
                                'height' => 45,
                                'alignment' => 'right',
                                'static' => false
                            ),
                            'alignment' => 'right',
                            'static' => false,
                            'position' => '1',
                            'type' => 'content'
                        ),
                        'block-2' => array(
                            'text' => array(
                                'value' => '<h3>'.sprintf(__('%sTo edit%s, mouse over to show edit button below.', WYSIJA), '<strong>', '</strong>').'</h3>'
                            ),
                            'image' => array(
                                'src' => WYSIJA_EDITOR_IMG.'default-newsletter/autonewsletter/arrow-down.png',
                                'width' => 150,
                                'height' => 53,
                                'alignment' => 'left',
                                'static' => false
                            ),
                            'alignment' => 'left',
                            'static' => false,
                            'position' => '2',
                            'type' => 'content'
                        ),
                        'block-3' => array(
                            'params' => $autopostParams,
                            'position' => '3',
                            'type' => 'auto-post'
                        )
                    ),
                    'footer' => array(
                        'text' => NULL,
                        'image' => array(
                            'src' => WYSIJA_EDITOR_IMG.'transparent.png',
                            'width' => 600,
                            'height' => 86,
                            'alignment' => 'center',
                            'static' => true,
                        ),
                        'alignment' => 'center',
                        'static' => true,
                        'type' => 'footer'
                    )
                );
            } else {
                if(!isset($emaildata['params'])) $emaildata['params']=array();
                $emaildata['params']['quickselection'] = array(
                        'wp-301' => array(
                            'identifier' => 'wp-301',
                            'width' => 281,
                            'height' => 190,
                            'url' => WYSIJA_EDITOR_IMG.'default-newsletter/newsletter/pigeon.png',
                            'thumb_url' => WYSIJA_EDITOR_IMG.'default-newsletter/newsletter/pigeon-150x150.png'
                        )
                );

                $hDividers =& WYSIJA::get('dividers', 'helper');
                $defaultDivider = $hDividers->getDefault();

                $hBookmarks =& WYSIJA::get('bookmarks', 'helper');
                $bookmarks = $hBookmarks->getAllByIconset('medium', '02');

                $newwjdata = array(
                    'version' => WYSIJA::get_version(),
                    'header' => array(
                        'text' => null,
                        'image' => array(
                            'src' => WYSIJA_EDITOR_IMG.'default-newsletter/newsletter/header.png',
                            'width' => 600,
                            'height' => 72,
                            'alignment' => 'center',
                            'static' => false
                        ),
                        'alignment' => 'center',
                        'static' => false,
                        'type' => 'header'
                    ),
                    'body' => array(
                        'block-1' => array(
                            'text' => array(
                                'value' => '<h2><strong>'.__('Step 1:', WYSIJA).'</strong> '.__('hey, click on this text!', WYSIJA).'</h2>'.'<p>'.__('To edit, simply click on this block of text.', WYSIJA).'</p>'
                            ),
                            'image' => null,
                            'alignment' => 'left',
                            'static' => false,
                            'position' => 1,
                            'type' => 'content'
                        ),
                        'block-2' => array_merge(array(
                                'position' => 2,
                                'type' => 'divider'
                            ), $defaultDivider
                        ),
                        'block-3' => array(
                            'text' => array(
                                'value' => '<h2><strong>'.__('Step 2:', WYSIJA).'</strong> '.__('play with this image', WYSIJA).'</h2>'
                            ),
                            'image' => null,
                            'alignment' => 'left',
                            'static' => false,
                            'position' => 3,
                            'type' => 'content'
                        ),
                        'block-4' => array(
                            'text' => array(
                                'value' => '<p>'.__('Position your mouse over the image to the left.', WYSIJA).'</p>'
                            ),
                            'image' => array(
                                'src' => WYSIJA_EDITOR_IMG.'default-newsletter/newsletter/pigeon.png',
                                'width' => 281,
                                'height' => 190,
                                'alignment' => 'left',
                                'static' => false
                            ),
                            'alignment' => 'left',
                            'static' => false,
                            'position' => 4,
                            'type' => 'content'
                        ),
                        'block-5' => array_merge(array(
                                'position' => 5,
                                'type' => 'divider'
                            ), $defaultDivider
                        ),
                        'block-6' => array(
                            'text' => array(
                                'value' => '<h2><strong>'.__('Step 3:', WYSIJA).'</strong> '.__('drop content here', WYSIJA).'</h2>'.
                                            '<p>'.sprintf(__('Drag and drop %1$stext, posts, dividers.%2$s Look on the right!', WYSIJA), '<strong>', '</strong>').'</p>'.
                                            '<p>'.sprintf(__('You can even %1$ssocial bookmarks%2$s like these:', WYSIJA), '<strong>', '</strong>').'</p>'
                            ),
                            'image' => null,
                            'alignment' => 'left',
                            'static' => false,
                            'position' => 6,
                            'type' => 'content'
                        ),
                        'block-7' => array(
                            'width' => 184,
                            'alignment' => 'center',
                            'items' => array(
                                array_merge(array(
                                    'url' => 'http://www.facebook.com/wysija',
                                    'alt' => 'Facebook',
                                    'cellWidth' => 61,
                                    'cellHeight' => 32
                                ), $bookmarks['facebook']),
                                array_merge(array(
                                    'url' => 'http://www.twitter.com/wysija',
                                    'alt' => 'Twitter',
                                    'cellWidth' => 61,
                                    'cellHeight' => 32
                                ), $bookmarks['twitter']),
                                array_merge(array(
                                    'url' => 'https://plus.google.com/104749849451537343615',
                                    'alt' => 'Google',
                                    'cellWidth' => 61,
                                    'cellHeight' => 32
                                ), $bookmarks['google'])
                            ),
                            'position' => 7,
                            'type' => 'gallery'
                        ),
                        'block-8' => array_merge(array(
                                'position' => 8,
                                'type' => 'divider'
                            ), $defaultDivider
                        ),
                        'block-9' => array(
                            'text' => array(
                                'value' => '<h2><strong>'.__('Step 4:', WYSIJA).'</strong> '.__('and the footer?', WYSIJA).'</h2>'.
                                            '<p>'.sprintf(__('Change the footer\'s content in Wysija\'s %1$sSettings%2$s page.', WYSIJA), '<strong>', '</strong>').'</p>'
                            ),
                            'image' => null,
                            'alignment' => 'left',
                            'static' => false,
                            'position' => 9,
                            'type' => 'content'
                        )
                    ),
                    'footer' => array(
                        'text' => NULL,
                        'image' => array(
                            'src' => WYSIJA_EDITOR_IMG.'default-newsletter/newsletter/footer.png',
                            'width' => 600,
                            'height' => 46,
                            'alignment' => 'center',
                            'static' => false,
                        ),
                        'alignment' => 'center',
                        'static' => false,
                        'type' => 'footer'
                    )
                );
            }
            $emaildata['wj_data'] = base64_encode(serialize($newwjdata));

            $emaildata['wj_styles'] = base64_encode(serialize(array(
                'html' => array(
                    'background' => 'e8e8e8'
                ),
                'header' => array(
                    'background' => 'e8e8e8'
                ),
                'body' => array(
                    'color' => '000000',
                    'family' => 'Arial',
                    'size' => 16,
                    'background' => 'ffffff'
                ),
                'footer' => array(
                    'background' => 'e8e8e8'
                ),
                'h1' => array(
                    'color' => '000000',
                    'family' => 'Trebuchet MS',
                    'size' => 40
                ),
                'h2' => array(
                    'color' => '424242',
                    'family' => 'Trebuchet MS',
                    'size' => 30
                ),
                'h3' => array(
                    'color' => '424242',
                    'family' => 'Trebuchet MS',
                    'size' => 24
                ),
                'a' => array(
                    'color' => '0000FF',
                    'underline' => false
                ),
                'unsubscribe' => array(
                    'color' => '000000'
                ),
                'viewbrowser' => array(
                    'color' => '000000',
                    'family' => 'Arial',
                    'size' => 12
                )
            )));
            $email_id=$data['email']['email_id']=$modelEmail->insert($emaildata);
            $this->notice(__('Newsletter successfully created.',WYSIJA));
        }
        $this->_saveLists($campaign_id,true);
        if(isset($_REQUEST['return'])) $this->redirect();
        else {
            $this->redirect('admin.php?page=wysija_campaigns&action=editTemplate&id='.$email_id);
        }
    }
    function saveemail(){
        $this->redirectAfterSave=false;

        $modelEmail=&WYSIJA::get("email","model");
        $modelEmail->fieldValid=false;
        $emaildataarr=$modelEmail->getOne(array('email_id'=>$_REQUEST['id']));
        if(isset($_REQUEST['save-reactivate'])){

            $dataEmail['status']=99;
            $_REQUEST['return']=1;
        }
        if(isset($_REQUEST['return'])) $this->redirect();
        else {
            $this->redirect('admin.php?page=wysija_campaigns&action=editDetails&id='.$emaildataarr['email_id']);
        }
    }

    function savelast(){
        $this->redirectAfterSave=false;
        $post_notification=false;
        $this->requireSecurity();
        if(!isset($_POST['wysija']['email']['from_name'])|| !isset($_POST['wysija']['email']['from_email']) || !isset($_POST['wysija']['email']['replyto_name']) || !isset($_POST['wysija']['email']['replyto_email'])){
            $this->error(__('Information is missing.',WYSIJA));
            return $this->editDetails();
        }
        if(isset($_REQUEST['wysija']['email']['params']['googletrackingcode']) && $_REQUEST['wysija']['email']['params']['googletrackingcode'] &&
                (!is_string($_REQUEST['wysija']['email']['params']['googletrackingcode'])
                OR
                preg_match('#[^a-z0-9_]#i',$_REQUEST['wysija']['email']['params']['googletrackingcode']) !== 0 )){

            $_REQUEST['wysija']['email']['params']['googletrackingcode']=preg_replace('#[^a-z0-9_]#i', '_',$_REQUEST['wysija']['email']['params']['googletrackingcode']);
            $this->error(__('The Google Campaign name needs to be only letters and number, with no spaces allowed. We\'ll improve this in the future!',WYSIJA),1);
            return $this->editDetails();
        }
        $update_email=array(
            'email_id'=>$_POST['wysija']['email']['email_id'],
            'from_name'=>$_POST['wysija']['email']['from_name'],
            'from_email'=>$_POST['wysija']['email']['from_email'],
            'replyto_name'=>$_POST['wysija']['email']['replyto_name'],
            'replyto_email'=>$_POST['wysija']['email']['replyto_email'],
            'subject'=>$_POST['wysija']['email']['subject'],
        );
        $model_email=&WYSIJA::get('email','model');
        if(isset($_POST['wysija']['email']['params']))  $update_email['params']=$_POST['wysija']['email']['params'];

        $this->_saveLists($_POST['wysija']['campaign']['campaign_id']);
        $email_data=$model_email->getOne($_POST['wysija']['email']['email_id']);
        if(isset($_POST['submit-draft']) || isset($_POST['submit-pause']) || (isset($_REQUEST['wj_redir']) && $_REQUEST['wj_redir']=='savelastback')){
            if(isset($_POST['wysija']['email']['params']['schedule']['isscheduled']))   $this->notice(__('Newsletter has been scheduled.',WYSIJA));
            else $this->notice(__('Newsletter has been saved as a draft.',WYSIJA));
        }else{

            foreach($update_email as $ki =>$vi)  {
                if($ki=='params'){
                    foreach($vi as $parake=>$paraval){
                        $email_data['params'][$parake]=$paraval;
                    }
                    $update_email[$ki]=$email_data[$ki];
                }else $email_data[$ki]=$vi;
            }


            $queue_emails=false;
            $do_send=true;
            if((int)$email_data['type']==2 && isset($email_data['params']['autonl']['event']) && $email_data['params']['autonl']['event']=='new-articles' )  $post_notification=true;
            if((int)$email_data['type']==1 && !isset($_POST['submit-resume']) && !isset($email_data['params']['schedule']['isscheduled']))   $queue_emails=true;

            if($post_notification || isset($email_data['params']['schedule']['isscheduled']))  $do_send=false;
            if($do_send===true)   $model_email->send($email_data,$queue_emails);
            if((int)$email_data['type']==1)  {
                if(isset($email_data['params']['schedule']['isscheduled'])){
                    $update_email['status']=4;
                    $this->notice(__('Newsletter has been scheduled.',WYSIJA));
                }
                else $this->notice(__('Your latest newsletter is being sent.',WYSIJA));
            }
            else $this->notice(__('Your auto newsletter has been activated.',WYSIJA));
        }

        $update_email['type']=$email_data['type'];
        if($post_notification){
            $helper_autonews=&WYSIJA::get('autonews','helper');
            $update_email['params']['autonl']['nextSend']=$helper_autonews->getNextSend($update_email);
        }
        $model_email->reset();
        $model_email->columns['modified_at']['autoup']=1;
        $model_email->update($update_email);
        $model_campaign=&WYSIJA::get('campaign','model');
        $model_campaign->reset();
        $update_campaign=array('campaign_id'=>$_REQUEST['id'],'name'=>$_POST['wysija']['email']['subject']);
        $model_campaign->update($update_campaign);
        if(isset($_REQUEST['wj_redir']) && $_REQUEST['wj_redir']=='savelastback'){
            return $this->redirect('admin.php?page=wysija_campaigns&action=editTemplate&id='.$_POST['wysija']['email']['email_id']);
        }
        else return $this->redirect();
    }

    function _saveLists($campaignId,$flagup=false){

        $modelCampL=&WYSIJA::get('campaign_list','model');
        if($flagup || (int)$campaignId>0){
            $modelCampL->delete(array('equal'=>array('campaign_id'=>$campaignId)));
            $modelCampL->reset();
        }
        if(isset($_POST['wysija']['campaign_list']['list_id'])){

            foreach($_POST['wysija']['campaign_list']['list_id'] as $listid){
                $modelCampL->insert(array('campaign_id'=>$campaignId,"list_id"=>$listid));
            }
        }
    }

    function _addLinkFilter($status,$type='status'){
        switch($type){
            case 'status':
                switch($status){
                    case 'draft':
                        $this->filters['equal']=array('status'=>0);
                        break;
                    case 'sending':
                        $this->filters['equal']=array('status'=>99);
                        break;
                    case 'sent':
                        $this->filters['equal']=array('status'=>2);
                        break;
                    case 'paused':
                        $this->filters['equal']=array('status'=>-1);
                        break;
                    case 'scheduled':
                        $this->filters['equal']=array('status'=>4);
                        break;
                }
                break;
            case 'type':
                switch($status){
                    case 'regular':
                        $this->filters['equal']=array('type'=>1);
                        break;
                    case 'autonl':
                        $this->filters['equal']=array('type'=>2);
                        break;
                }
                break;
        }
    }
    function defaultDisplay(){
        $this->title=__('Newsletters',WYSIJA);
        $this->viewShow=$this->action='main';
        $this->js[]='wysija-admin-list';
        $this->jsTrans["selecmiss"]=__('Please select a newsletter.',WYSIJA);
        $this->jsTrans['suredelete']=__('Delete this newsletter for ever?',WYSIJA);
        $this->jsTrans['processqueue']=__('Sending batch of emails...',WYSIJA);
        $this->jsTrans['viewnews']=__('View newsletter',WYSIJA);
        $this->jsTrans['confirmpauseedit']=__('The newsletter will be deactivated, you will need to reactivate it once you\'re over editing it. Do you want to proceed?',WYSIJA);

        $autoNL=&WYSIJA::get('autonews','helper');
        $autoNL->checkPostNotif();
        $autoNL->checkScheduled();
        $config=&WYSIJA::get('config','model');

        if(isset($_REQUEST['search']) && $_REQUEST['search']){
            $this->filters["like"]=array();
            foreach($this->searchable as $field)
                $this->filters["like"][$field]=$_REQUEST['search'];
        }
        if(isset($_REQUEST['filter-list']) && $_REQUEST['filter-list']){
            $this->filters['equal']=array('C.list_id'=>$_REQUEST['filter-list']);
        }
        if(isset($_REQUEST['filter-date']) && $_REQUEST['filter-date']){
            $this->filters["greater_eq"]=array('created_at'=>$_REQUEST['filter-date']);
            $this->filters["less_eq"]=array('created_at'=>strtotime("+1 month",$_REQUEST['filter-date']));
        }
        if(isset($_REQUEST['link_filter']) && $_REQUEST['link_filter']){
            $linkfilters=explode('-',$_REQUEST['link_filter']);
            if(count($linkfilters)>1){
                $this->_addLinkFilter($linkfilters[1],$linkfilters[0]);
            }else{
                $this->_addLinkFilter($_REQUEST['link_filter']);
            }
        }
        $this->modelObj->noCheck=true;

        $queryCmmonStart="SELECT count(distinct A.campaign_id) as campaigns FROM `[wysija]".$this->modelObj->table_name."` as A";
        $queryCmmonStart.=' LEFT JOIN `[wysija]email` as B on A.campaign_id=B.campaign_id';
        $queryCmmonStart.=' LEFT JOIN `[wysija]campaign_list` as C on A.campaign_id=C.campaign_id';

        $query='SELECT count(email_id) as campaigns,  status FROM `[wysija]email` WHERE campaign_id > 0 GROUP BY status';
        $countss=$this->modelObj->query('get_res',$query,ARRAY_A);
        $counts=array();
        $total=0;
        foreach($countss as $count){
            switch($count['status']){
                case '0':
                    $type='draft';
                    break;
                case '1':
                case '3':
                case '99':
                    $type='sending';
                    break;
                case '2':
                    $type='sent';
                    break;
                case '-1':
                    $type='paused';
                    break;
                case '4':
                    $type='scheduled';
                    break;
            }
            $total=$total+$count['campaigns'];
            $counts['status-'.$type]=$count['campaigns'];
        }

        $query='SELECT count(email_id) as campaigns, type FROM `[wysija]email` WHERE campaign_id > 0 GROUP BY type';
        $countss=$this->modelObj->query('get_res',$query,ARRAY_A);
        foreach($countss as $count){
            switch($count['type']){
                case '1':
                    $type='regular';
                    break;
                case '2':
                    $type='autonl';
                    break;
            }
            $counts['type-'.$type]=$count['campaigns'];
        }
        $counts['all']=$total;
        $this->modelObj->reset();
        if($this->filters)  $this->modelObj->setConditions($this->filters);

        $query='SELECT A.campaign_id, A.name as campaign_name, B.subject as name, A.description, B.params , B.type , B.number_opened,B.number_clicked,B.number_unsub,B.status,B.status,B.created_at,B.modified_at,B.sent_at,B.email_id FROM `[wysija]'.$this->modelObj->table_name.'` as A';
        $query.=' LEFT JOIN `[wysija]email` as B on A.campaign_id=B.campaign_id';
        $query.=' LEFT JOIN `[wysija]campaign_list` as C on A.campaign_id=C.campaign_id';
        $queryFinal=$this->modelObj->makeWhere();


        $query2='SELECT MIN(B.created_at) as datemin FROM `[wysija]'.$this->modelObj->table_name.'` as A';
        $query2.=' LEFT JOIN `[wysija]email` as B on A.campaign_id=B.campaign_id';
        $query2.=' LEFT JOIN `[wysija]campaign_list` as C on A.campaign_id=C.campaign_id';
        $queryFinal2=$this->modelObj->makeWhere();

        if($this->filters)  $this->modelObj->countRows=$this->modelObj->count($queryCmmonStart.$queryFinal,'campaigns');
        else $this->modelObj->countRows=$counts['all'];
        $orderby=' ORDER BY ';
        if(isset($_REQUEST['orderby'])){
            if(!is_string($_REQUEST['orderby']) OR preg_match('|[^a-z0-9#_.-]|i',$_REQUEST['orderby']) !== 0 ){
                $_REQUEST['orderby']='';
            }
            if(!in_array(strtoupper($_REQUEST['ordert']),array('DESC','ASC'))) $_REQUEST['ordert'] = 'DESC';
            $orderby.=$_REQUEST['orderby'].' '.$_REQUEST['ordert'];
        }else{
            $orderby=' ORDER BY ';
            $orderby.='FIELD(B.status, 99,3,1,0,2), ';
            $orderby.='B.status desc, ';
            $orderby.='B.modified_at desc, ';
            $orderby.='B.sent_at desc, ';
            $orderby.='B.type desc, ';
            $orderby.='A.'.$this->modelObj->getPk().' desc';
        }


        $this->data['campaigns']=$this->modelObj->getResults($query.$queryFinal.' GROUP BY B.email_id'.$orderby.$this->modelObj->setLimit());

        $emailids=array();
        foreach($this->data['campaigns'] as $emailcamp){
            if(in_array($emailcamp['status'], array(1,3,99))) $emailids[]=$emailcamp['email_id'];
        }
        $modelQ=&WYSIJA::get('queue','model');
        $modelQ->setConditions(array("email_id"=>$emailids));
        $modelQ->groupBy('email_id');
        $queue=$modelQ->count();
        if($queue){
            $this->viewObj->queuedemails=$queue;
        }
        $this->modelObj->reset();
        $this->data['datemin']=$this->modelObj->query('get_row',$query2.$queryFinal2);
        $this->modelObj->reset();

        $now=time();
        $this->data['dates']=array();
        if((int)$this->data['datemin']['datemin']>1){
            setlocale(LC_TIME, 'en_US');
            $firstdayof=getdate($this->data['datemin']['datemin']);
            $formtlettres="1 ".date("F",$this->data['datemin']['datemin'])." ".date("Y",$this->data['datemin']['datemin']) ;
            $monthstart=strtotime($formtlettres);
            if($monthstart>0){
               for($i=$monthstart;$i<$now;$i=strtotime('+1 month',$i)){
                    $this->data['dates'][$i]=date_i18n('F Y',$i);//date('F Y',$i);
                }
            }
        }

        $modelList=&WYSIJA::get('list','model');

        $query='SELECT A.list_id, A.name,A.is_enabled, count( B.campaign_id ) AS users FROM `[wysija]'.$modelList->table_name.'` as A';
        $query.=' LEFT JOIN `[wysija]campaign_list` as B on A.list_id = B.list_id';
        $query.=' GROUP BY A.list_id';
        $listsDB=$modelList->getResults($query);
        $lists=array();
        foreach($listsDB as $listobj){
            $lists[$listobj["list_id"]]=$listobj;
        }
        $listsDB=null;
        $campaign_ids_sent=$campaign_ids=array();
        foreach($this->data['campaigns'] as &$campaign){
            $campaign_ids[]=$campaign['campaign_id'];
            $modelEmail=&WYSIJA::get('email','model');
            $modelEmail->getParams($campaign);
            if(in_array((int)$campaign['status'],array(-1,1,2,3,99)))  $campaign_ids_sent[]=$campaign['campaign_id'];
        }

        if($campaign_ids){
            $modeluList=&WYSIJA::get('campaign_list','model');
            $userlists=$modeluList->get(array('list_id','campaign_id'),array('campaign_id'=>$campaign_ids));
            if($campaign_ids_sent){
                $modeluList=&WYSIJA::get("email_user_stat","model");
                $statstotal=$modeluList->getResults("SELECT COUNT(A.user_id) as count,B.email_id FROM `[wysija]queue` as A
                     JOIN `[wysija]email` as B on A.email_id=B.email_id
                        WHERE B.campaign_id IN (".implode(",",$campaign_ids_sent).") group by B.email_id");
                $senttotalgroupedby=$modeluList->getResults("SELECT COUNT(A.user_id) as count,B.campaign_id,B.email_id,B.type,B.status,A.status as statususer FROM `[wysija]".$modeluList->table_name."` as A
                     JOIN `[wysija]email` as B on A.email_id=B.email_id
                        WHERE B.campaign_id IN (".implode(",",$campaign_ids_sent).") group by A.status,B.email_id");//,A.status

                $updateEmail=array();
                $columnnamestatus=array(0=>"number_sent",1=>"number_opened",2=>"number_clicked",3=>"number_unsub",-1=>"number_bounce");
                foreach($senttotalgroupedby as $sentbystatus){
                    if($sentbystatus['statususer']!="-2")   $updateEmail[$sentbystatus['email_id']][$columnnamestatus[$sentbystatus['statususer']]]=$sentbystatus['count'];
                    if(isset($senttotal[$sentbystatus['email_id']])){
                        $senttotal[$sentbystatus['email_id']]['count']=(int)$senttotal[$sentbystatus['email_id']]['count']+(int)$sentbystatus['count'];
                    }else{
                        unset($sentbystatus['statususer']);
                        $senttotal[$sentbystatus['email_id']]=$sentbystatus;
                    }
                }
                $modelEmail=&WYSIJA::get('email','model');
                foreach($updateEmail as $emailid=>$update){
                    foreach($columnnamestatus as $v){
                        if(!isset($update[$v])) $update[$v]=0;
                    }
                    $modelEmail->update($update,array('email_id'=>$emailid));
                    $modelEmail->reset();
                }

                
                $modelC=&WYSIJA::get('config','model');
                $running=false;
                $is_multisite=is_multisite();

                if($is_multisite && $modelC->getValue('sending_method')=='network'){
                   $sending_emails_each=$modelC->getValue('ms_sending_emails_each');
                }else{
                   $sending_emails_each=$modelC->getValue('sending_emails_each');
                }
                if($modelC->getValue('cron_manual')){
                    $formsHelp=&WYSIJA::get('forms','helper');
                    $queue_frequency=$formsHelp->eachValuesSec[$sending_emails_each];
                    $queue_scheduled=WYSIJA::get_cron_schedule('queue');
                    $next_scheduled_queue=$queue_scheduled['next_schedule'];
                    $running=$queue_scheduled['running'];
                    if($running){
                        $helperToolbox=&WYSIJA::get('toolbox','helper');
                        $running=time()-$running;
                        $running=$helperToolbox->duration($running,true,4);
                    }
                }else{
                    $schedules=wp_get_schedules();
                    $queue_frequency=$schedules[wp_get_schedule('wysija_cron_queue')]['interval'];
                    $next_scheduled_queue=wp_next_scheduled('wysija_cron_queue');
                }

                $status_sent_complete=array();
                if(isset($senttotal) && $senttotal){
                    foreach($senttotal as $sentot){
                        if($sentot){
                            $this->data['sent'][$sentot['email_id']]['total']=$sentot['count'];
                            $this->data['sent'][$sentot['email_id']]['to']=$sentot['count'];
                        }else{
                            $this->data['sent'][$sentot['email_id']]['total']=$this->data['sent'][$sentot['email_id']]['to']=0;
                        }
                        $this->data['sent'][$sentot['email_id']]['status']=$sentot['status'];
                        $this->data['sent'][$sentot['email_id']]['type']=$sentot['type'];
                        $this->data['sent'][$sentot['email_id']]['left']= (int)$this->data['sent'][$sentot['email_id']]['total'] - (int)$this->data['sent'][$sentot['email_id']]['to'];
                    }
                }
                foreach($statstotal as $sentot){
                    if(!isset($this->data['sent'][$sentot['email_id']])) {
                        $this->data['sent'][$sentot['email_id']]['total']=0;
                        $this->data['sent'][$sentot['email_id']]['to']=0;
                    }
                    $this->data['sent'][$sentot['email_id']]['total']=$this->data['sent'][$sentot['email_id']]['total']+$sentot['count'];
                    $this->data['sent'][$sentot['email_id']]['left']= (int)$this->data['sent'][$sentot['email_id']]['total'] - (int)$this->data['sent'][$sentot['email_id']]['to'];
                }

                $is_multisite=is_multisite();

                if($is_multisite && $modelC->getValue('sending_method')=='network'){
                   $sending_emails_number=$modelC->getValue('ms_sending_emails_number');
                }else{
                   $sending_emails_number=$modelC->getValue('sending_emails_number');
                }
               if(isset($this->data['sent'])){
                   foreach($this->data['sent'] as $key => $camp){
                        if($this->data['sent'][$key]['left']>0){
                            $cronsneeded=ceil($this->data['sent'][$key]['left']/$sending_emails_number);
                            $this->data['sent'][$key]['remaining_time']=$cronsneeded *$queue_frequency;
                            $this->data['sent'][$key]['running_for']=$running;
                            $this->data['sent'][$key]['next_batch']=$next_scheduled_queue-time();
                            $this->data['sent'][$key]['remaining_time']=$this->data['sent'][$key]['remaining_time']-($queue_frequency)+$this->data['sent'][$key]['next_batch'];
                        }else{
                            if( (in_array($this->data['sent'][$key]['status'], array(1,3,99))) && $this->data['sent'][$key]['type']==1) $status_sent_complete[]=$key;
                        }
                    }
               }

                
                if(count($status_sent_complete)>0){
                    $modelEmail=&WYSIJA::get('email','model');
                    $modelEmail->noCheck=true;
                    $modelEmail->reset();
                    $modelEmail->update(array('status'=>2),array('equal'=>array('email_id'=>$status_sent_complete)));
                }
            }
        }
        $this->data['lists']=$lists;
        $this->data['counts']=array_reverse($counts);
        
        foreach($this->data['campaigns'] as $keysus=>&$campaign){
            

            $campaign["emails"]=0;
            $campaign["opened"]=0;
            $campaign["clicked"]=0;
            if($userlists){
                foreach($userlists as $key=>$userlist){
                    if($campaign["campaign_id"]==$userlist["campaign_id"] && isset($lists[$userlist["list_id"]])){
                        if(!isset($campaign["lists"]) ) $campaign["lists"]=$lists[$userlist["list_id"]]["name"];
                        else $campaign["lists"].=", ".$lists[$userlist["list_id"]]["name"];
                    }
                }
            }
            if(isset($campaign["lists"]) && !$campaign["lists"]) unset($campaign["lists"]);
            if(((isset($campaign['params']['schedule']['isscheduled'])
                ||
                ($campaign['type']==2 && isset($campaign['params']['autonl']['event']) && in_array($campaign['params']['autonl']['event'],array('new-articles')))
               )
                && $campaign['status']!=2 && !isset($campaign["lists"]))
                    || ($campaign['type']==2 && isset($campaign['params']['autonl']['event']) && in_array($campaign['params']['autonl']['event'],array('subs-2-nl')) && $campaign['status']!=2 && (!isset($campaign['params']['autonl']['subscribetolist']) || !isset($lists[$campaign['params']['autonl']['subscribetolist']]) ))
            ){
                $campaign['classRow']=" listmissing ";
                $campaign['msgListEdit']='<strong>'.__('The list has been deleted.',WYSIJA).'</strong>';
                $campaign['msgSendSuspended']='<strong>'.__('Sending suspended.',WYSIJA).'</strong>';
            }

        }
        $this->dataAutoNl();
        if(!$this->data['campaigns']){
            $this->notice(__("We looked everywhere, but we couldn't find the newsletter you're looking for.",WYSIJA));
        }
    }

    function setviewStatsfilter(){
        
        $this->searchable=array("email", "firstname", "lastname");
        $this->filters=array();
        if(isset($_REQUEST['search']) && $_REQUEST['search']){
            $this->filters["like"]=array();
            foreach($this->searchable as $field)
                $this->filters["like"][$field]=$_REQUEST['search'];
        }
        $this->tableQuery='email_user_stat';
        $this->statusemail='B.status as umstatus';
        if(isset($_REQUEST['link_filter']) && $_REQUEST['link_filter']){
            switch($_REQUEST['link_filter']){
                case "inqueue":
                    $this->tableQuery='queue';
                    $this->statusemail="-2 as umstatus";
                    break;
                case "sent":
                    $this->filters["equal"]=array('B.status'=>0);
                    break;
                case "bounced":
                    $this->filters["equal"]=array('B.status'=>-1);
                    break;
                case "opened":
                    $this->filters["equal"]=array('B.status'=>1);
                    break;
                case "clicked":
                    $this->filters["equal"]=array('B.status'=>2);
                    break;
                case "unsubscribe":
                    $this->filters["equal"]=array('B.status'=>3);
                    break;
                case 'notsent':
                    $this->filters["equal"]=array('B.status'=>-2);
                    break;
            }
        }
    }
    function viewstats(){
        $this->js[]='wysija-admin-list';
        $this->js[]='wysija-charts';
        $this->viewShow='viewstats';
        $this->modelObj=&WYSIJA::get("email","model");
        $this->modelObj->limitON=false;
        $emailObj=$this->modelObj->getOne(false,array("email_id"=>$_REQUEST['id']));
        $this->viewObj->model=$this->modelObj;
        $this->viewObj->namecampaign=$emailObj['subject'];
        $this->viewObj->title=sprintf(__('Stats : %1$s',WYSIJA),$emailObj['subject']);
        $modelObjCamp=&WYSIJA::get("campaign","model");
        $limit_pp=false;
        if(isset($modelObjCamp->limit_pp)) $limit_pp = $modelObjCamp->limit_pp;
       $modelObjCamp->limitON=false;
        $campaign=$modelObjCamp->getOne(false,array("campaign_id"=>$emailObj['campaign_id']));

        $this->setviewStatsfilter();
        $this->modelObj->reset();
        $this->modelObj->noCheck=true;
        
        $queryCmmonStart='SELECT count(distinct B.user_id) as users FROM `[wysija]user` as A';
        $queryCmmonStart.=' LEFT JOIN `[wysija]'.$this->tableQuery.'` as B on A.user_id=B.user_id';
        
        $query="SELECT count(user_id) as users, status FROM `[wysija]email_user_stat` as A
            WHERE A.email_id=".$emailObj['email_id']." GROUP BY status";
        $countss=$this->modelObj->query("get_res",$query,ARRAY_A);
        
        $query="SELECT count(user_id) as users FROM `[wysija]queue` as A
            WHERE A.email_id=".$emailObj['email_id'];
        $countss[-2]['status']=-3;
        $countss[-2]['users']=$this->modelObj->count($query,'users');
        $counts=array();
        $truetotal=$total=0;
        foreach($countss as $count){
            switch($count['status']){
                case "-3":
                    $type='inqueue';
                    break;
                case "-2":
                    $type='notsent';
                    break;
                case "-1":
                    $type='bounced';
                    break;
                case "0":
                    $type='sent';
                    break;
                case "1":
                    $type='opened';
                    break;
                case "2":
                    $type='clicked';
                    break;
                case "3":
                    $type='unsubscribe';
                    break;
            }
            if($count['status']!="-2")  $total=$total+$count['users'];
            $truetotal=$truetotal+$count['users'];
            $counts[$type]=$count['users'];
        }
        $counts['allsent']=$total;
        $counts['all']=$truetotal;
        $this->modelObj->reset();
        $this->filters['equal']["B.email_id"]=$emailObj['email_id'];
        $this->modelObj->noCheck=true;
        if($this->filters)  $this->modelObj->setConditions($this->filters);

        
        $query='SELECT A.user_id, A.firstname, A.lastname,A.status as ustatus,'.$this->statusemail.' , A.email, A.created_at FROM `[wysija]user` as A';
        $query.=' LEFT JOIN `[wysija]'.$this->tableQuery.'` as B on A.user_id=B.user_id';
        $queryFinal=$this->modelObj->makeWhere();
        
        if($this->filters)  $this->modelObj->countRows=$this->modelObj->count($queryCmmonStart.$queryFinal,'users');
        else $this->modelObj->countRows=$counts['all'];
        $orderby=" ORDER BY ";
        if(isset($_REQUEST['orderby'])){
            $orderby.=$_REQUEST['orderby']." ".$_REQUEST['ordert'];
        }else{
            $orderby.=$this->modelObj->pk." desc";
        }
        $this->modelObj->limitON=true;
        $this->data['subscribers']=$this->modelObj->getResults($query.$queryFinal." GROUP BY A.user_id".$orderby.$this->modelObj->setLimit(0,$limit_pp));
        $this->modelObj->reset();
        
        $modelList=&WYSIJA::get("list","model");
        
        $query="SELECT A.list_id, A.name,A.is_enabled, count( B.user_id ) AS users FROM `[wysija]".$modelList->table_name."` as A";
        $query.=" LEFT JOIN `[wysija]user_list` as B on A.list_id = B.list_id";
        $query.=" GROUP BY A.list_id";
        $listsDB=$modelList->getResults($query);
        $lists=array();
        foreach($listsDB as $listobj){
            $lists[$listobj["list_id"]]=$listobj;
        }
        $listsDB=null;
        $user_ids=array();
        foreach($this->data['subscribers'] as $subscriber){
            $user_ids[]=$subscriber['user_id'];
        }
        
        if($user_ids){
            $modeluList=&WYSIJA::get("user_list","model");
            $userlists=$modeluList->get(array("list_id","user_id"),array("user_id"=>$user_ids));
        }

        $this->data['lists']=$lists;
        $this->data['counts']=array_reverse($counts);
        
       foreach($this->data['subscribers'] as $keysus=>$subscriber){
            

            $this->data['subscribers'][$keysus]["emails"]=0;
            $this->data['subscribers'][$keysus]["opened"]=0;
            $this->data['subscribers'][$keysus]["clicked"]=0;
            if($userlists){
                foreach($userlists as $key=>$userlist){
                    if($subscriber["user_id"]==$userlist["user_id"] && isset($lists[$userlist["list_id"]])){
                        if(!isset($this->data['subscribers'][$keysus]["lists"]) ) $this->data['subscribers'][$keysus]["lists"]=$lists[$userlist["list_id"]]["name"];
                        else $this->data['subscribers'][$keysus]["lists"].=", ".$lists[$userlist["list_id"]]["name"];
                    }
                }
            }
        }

        

        $this->data['charts']['title']=" ";
        $this->data['charts']['stats']=array();
        $keys=array(
            'opened'=>array('order'=>0),
            'bounced'=>array('order'=>1),
            'sent'=>array('order'=>2),
            'clicked'=>array('order'=>3),
            'unsubscribe'=>array('order'=>4),
            'notsent'=>array('order'=>5),
            'inqueue'=>array('order'=>6)
            );
        foreach(array_reverse($counts) as $key=> $count){
            if($key!="all" && $key!="allsent"){
                if(isset($keys[$key]['name']))  $name=$keys[$key]['name'];
                else $name=$this->viewObj->getTransStatusEmail($key);
                if($count>0) $this->data['charts']['stats'][$keys[$key]['order']]=array("name"=>$name,"number"=>$count);
            }
        }
        $modelEUU=&WYSIJA::get('email_user_url',"model");
        $modelEUU->colCheck=false;
        $modelEUU->setConditions(array("equal"=>array("A.email_id"=>$emailObj['email_id'])));
        $query="SELECT count(A.user_id) as count,A.*,B.*,C.subject as name FROM `[wysija]".$modelEUU->table_name."` as A JOIN `[wysija]url` as B on A.url_id=B.url_id JOIN `[wysija]email` as C on C.email_id=A.email_id ";
        $query.=$modelEUU->makeWhere();
        $query.=" GROUP BY A.url_id ";
        $query.=" ORDER BY count Desc";
        $this->data['clicks']=$modelEUU->query("get_res",$query,ARRAY_A);

        foreach($this->data['clicks'] as $k => &$v){
            $this->data['clicks'][$k]['name']="<strong>".sprintf(_n('%1$s hit', '%1$s hits', $v['count'],WYSIJA), $v['count'])."</strong> ";
            $v['url']=urldecode(utf8_encode($v['url']));
        }
        $this->data['email']=$emailObj;
        $chartsencoded=base64_encode(json_encode($this->data['charts']));
        wp_enqueue_script('wysija-admin-subscribers-edit-manual', WYSIJA_URL."js/admin-subscribers-edit-manual.php?data=".$chartsencoded, array( 'wysija-charts' ), true);
        if(!$this->data['subscribers']){
            $this->notice(__("Your request can't retrieve any subscribers. Change your filters!",WYSIJA));
        }
    }
    function getListSubscriberQry($selectcolumns){
        $this->modelObj=&WYSIJA::get("email","model");
        $this->emailObj=$this->modelObj->getOne(false,array('email_id' => $_REQUEST['id']));
        
        $this->setviewStatsfilter();
        if($selectcolumns=="B.user_id"){

        }
        $this->filters['equal']["B.email_id"]=$this->emailObj['email_id'];
        $this->modelObj->noCheck=true;
        if($this->filters)  $this->modelObj->setConditions($this->filters);
        
        if($selectcolumns=="B.user_id"){
           $query="SELECT $selectcolumns FROM `[wysija]".$this->tableQuery."` as B";
           $query.=$this->modelObj->makeWhere();
        }else{
            $query="SELECT $selectcolumns FROM `[wysija]user` as A";
            $query.=" LEFT JOIN `[wysija]".$this->tableQuery."` as B on A.user_id=B.user_id";
            $query.=$this->modelObj->makeWhere();
        }
        return $query;
    }
    function createnewlist(){
        
        $emailModel =& WYSIJA::get('email', 'model');
        $email = $emailModel->getOne(array('subject'), array('email_id' => $_REQUEST['id']));
        $this->modelObj->reset();
        
        $prefix="";
        if(isset($_REQUEST['link_filter'])) $prefix=' ('.$this->viewObj->getTransStatusEmail($_REQUEST['link_filter']).')';
        $listname=sprintf(__('Segment of %1$s',WYSIJA), $email['subject'].$prefix);
        
        $modelL=&WYSIJA::get('list','model');
        $listid=$modelL->insert(array('is_enabled'=>1,'name'=>$listname,'description'=>__('List created based on a newsletter segment.',WYSIJA)));
        
        $query=$this->getListSubscriberQry($listid.', A.user_id, '.time().', 0');
        $query2='INSERT INTO `[wysija]user_list` (`list_id`,`user_id`,`sub_date`,`unsub_date`) '.$query;
        $this->modelObj->query($query2);
        $this->notice(sprintf(__('A new list "%1$s" has been created out of this segment.',WYSIJA), $listname));
        $this->redirect('admin.php?page=wysija_campaigns&action=viewstats&id='.$_REQUEST['id']);
    }
    function unsubscribeall(){

        $query=$this->getListSubscriberQry('B.user_id');
        $query2="UPDATE `[wysija]user_list` where user_id IN ($query) AND list_id not IN(SELECT list_id from `[wysija]list` WHERE is_enabled<1)";
        $this->modelObj->query($query2);

        $query2="UPDATE `[wysija]user` set `status`=-1 where user_id IN ($query)";
        $this->modelObj->query($query2);
        $this->notice(__('The segment has been unbsubscribed from all the lists.',WYSIJA));
        $this->redirect('admin.php?page=wysija_campaigns&action=viewstats&id='.$_REQUEST['id']);
    }

    function sendconfirmation(){

        $query=$this->getListSubscriberQry('B.user_id ');
        $user_ids=$this->modelObj->query('get_res',$query);
        $uids=array();
        foreach($user_ids as $data){
            $uids[]=$data['user_id'];
        }
        $helperUser=&WYSIJA::get('user','helper');
        $helperUser->sendConfirmationEmail($uids);
        $this->redirect('admin.php?page=wysija_campaigns&action=viewstats&id='.$_REQUEST['id']);
    }

    function removequeue(){
        
        $query=$this->getListSubscriberQry('B.user_id');
        $query2="DELETE FROM `[wysija]queue` where user_id IN ($query) AND email_id=".$this->emailObj['email_id'];
        $this->modelObj->query($query2);
        $this->notice(__('The segment has been removed from the queue of this newsletter.',WYSIJA));
        $this->redirect('admin.php?page=wysija_campaigns&action=viewstats&id='.$_REQUEST['id']);
    }
    function export(){
        
        $query=$this->getListSubscriberQry('B.user_id');
        $result=$this->modelObj->query('get_res',$query);
        $user_ids=array();
        foreach($result as $user) $user_ids[]=$user['user_id'];
        $fileHelp=&WYSIJA::get('file','helper');
        $tempfilename=$fileHelp->temp(implode(',',$user_ids),'export_userids','.txt');

        $this->redirect('admin.php?page=wysija_subscribers&action=exportcampaign&camp_id='.$_REQUEST['id'].'&file_name='.  base64_encode($tempfilename['path']));
    }

    function unsubscribelist($data){
        $modelL=&WYSIJA::get('list','model');
        $list=$modelL->getOne(false,array('list_id'=>$data['listid']));
        if($list['is_enabled']){
            
            $query=$this->getListSubscriberQry("B.user_id");
            $query2="DELETE FROM `[wysija]user_list` where user_id IN ($query) and list_id=".$data['listid'];
            $this->modelObj->query($query2);
            $this->notice(sprintf(__('The segment has been unbsubscribed from the list "%1$s"',WYSIJA),$list['name']));
        }else{
            $this->notice(sprintf(__('The segment cannot be unbsubscribed from an [IMPORT] list.',WYSIJA),$list['name']));
        }
        $this->redirect('admin.php?page=wysija_campaigns&action=viewstats&id='.$_REQUEST['id']);
    }

    function articles(){
       $this->iframeTabs=array('articles'=>__("Post Selection",WYSIJA));
       $this->js[]='wysija-admin-ajax';
       $this->js[]='wysija-base-script-64';
       $_GET['tab']='articles';
       return $this->popupContent();
    }
    function themeupload(){
        $helperNumbers=&WYSIJA::get('numbers','helper');
        $bytes=$helperNumbers->get_max_file_upload();
        if(isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH']>$bytes['maxbytes']){
            if(isset($_FILES['my-theme']['name']) && $_FILES['my-theme']['name']){
                $filename=$_FILES['my-theme']['name'];
            }else{
                $filename="";
            }
            $this->error(sprintf(__('Upload error, file %1$s is too large! (MAX:%2$s)',WYSIJA),$filename,$bytes['maxmegas']),true);
            $this->redirect('admin.php?page=wysija_campaigns&action=themes');
            return false;
        }

        $ZipfileResult=trim(file_get_contents($_FILES['my-theme']['tmp_name']));
        $themesHelp=&WYSIJA::get('themes','helper');
        $result=$themesHelp->installTheme($_FILES['my-theme']['tmp_name'],true);
        $this->redirect('admin.php?page=wysija_campaigns&action=themes&reload=1');
        return true;
    }
    function themes(){
       $this->iframeTabs = array('themes' => __('Install Themes', WYSIJA));
       $this->js[] = 'wysija-admin-ajax';
       $this->js[] = 'wysija-base-script-64';
       $this->jsTrans['viewinfos'] = __('Details & PSD', WYSIJA);
       $this->jsTrans['viewback'] = __('<< Back', WYSIJA);
       $this->jsTrans['install'] = __('Download', WYSIJA);
       $this->jsTrans['reinstall'] = __('Reinstall', WYSIJA);
       $this->jsTrans['premiumonly'] = __('Premium', WYSIJA);
        $model_config=&WYSIJA::get('config','model');

        if($model_config->getValue('premium_key'))$this->jsTrans['ispremium']=1;
        else $this->jsTrans['ispremium']=0;
        $this->jsTrans['premiumfiles']=__('Photoshop file available as part of [link]Premium features[/link].',WYSIJA);
        $helper_licence=&WYSIJA::get('licence','helper');
        $this->jsTrans['premiumfiles']=str_replace(array('[link]','[/link]'),array('<a class="premium-tab ispopup" href="javascript:;" >','</a>'),$this->jsTrans['premiumfiles']);
        $this->jsTrans['showallthemes']=__('Show all themes',WYSIJA);
        $this->jsTrans['totalvotes']=__('(%1$s votes)',WYSIJA);
        $this->jsTrans['voterecorded']=__("Your vote has been recorded.",WYSIJA);
        $this->jsTrans['votenotrecorded']=__("Your vote could not be recorded.",WYSIJA);
        $this->jsTrans['reinstallwarning']=__('Watch out! If you reinstall this theme all the files which are in the folder:/wp-content/uploads/wysija/themes/%1$s will be overwritten. Are you sure you want to reinstall?',WYSIJA);
        $this->jsTrans['errorconnecting']=__("We were unable to contact the API, the site may be down. Please try again later.",WYSIJA);
        $this->jsTrans['viewallthemes']=__('View all themes by %1$s',WYSIJA);
        $this->jsTrans['downloadpsd']=__("Download original Photoshop file",WYSIJA);
        $this->jsTrans['viewauthorsite']=__("View author's website",WYSIJA);
        $this->jsTrans['stars']=__('Average rating: %1$s',WYSIJA);
        $this->jsTrans['starsyr']=__('My rating: %1$s',WYSIJA);
        $this->jsTrans['downloads']=__('Downloads: %1$s',WYSIJA);
        $this->jsTrans['tags']=__('Tags: %1$s',WYSIJA);
        $this->jsTrans['lastupdated']=__('Last updated: %1$s',WYSIJA);
        $this->jsTrans['includes']=__('Includes: %1$s',WYSIJA);
        $helper_themes=&WYSIJA::get('themes','helper');
        $this->jsTrans['installedthemes']=$helper_themes->getInstalled();
        $url=admin_url('admin.php');
        $helper_toolbox=&WYSIJA::get("toolbox","helper");
        $domain_name=$helper_toolbox->_make_domain_name($url);
        $this->jsTrans['domainname']=$domain_name;
        $_GET['tab']='themes';
        return $this->popupContent();
    }
    function bookmarks() {
        $this->iframeTabs=array('bookmarks'=>__('Bookmarks Selection',WYSIJA));
        $this->js[]='wysija-admin-ajax';
        $_GET['tab']='bookmarks';
        $networks = array(
            'facebook' => array(
                'label' => 'Facebook',
                'url' => 'https://www.facebook.com/wysija'
            ),
            'twitter' => array(
                'label' => 'Twitter',
                'url' => 'https://twitter.com/#!/wysija'
            ),
            'google' => array(
                'label' => 'Google+',
                'url' => null
            ),
            'linkedin' => array(
                'label' => 'LinkedIn',
                'url' => null
            )
        );

        $model_config=&WYSIJA::get('config', 'model');
        $urls = $model_config->getValue('social_bookmarks');

        foreach($networks as $network => $values) {
            if(isset($urls[$network]) and strlen(trim($urls[$network])) > 0) {
                $networks[$network]['url'] = $urls[$network];
            }
        }
        $this->data['networks'] = $networks;
        $this->data['size'] = 'medium';
        $this->data['theme'] = isset($_REQUEST['theme']) ? $_REQUEST['theme'] : 'default';
        return $this->popupContent();
    }
    function dividers() {
        $this->iframeTabs=array('dividers'=>__("Dividers Selection",WYSIJA));
        $this->js[]='wysija-admin-ajax';
        $this->js[]='wysija-base-script-64';
        $_GET['tab']='dividers';
        $model_email =& WYSIJA::get('email', 'model');
        $this->data['email'] = $email = $model_email->getOne(false, array('email_id' => $_REQUEST['emailId']));

        $helper_dividers =& WYSIJA::get('dividers', 'helper');
        $dividers = $helper_dividers->getAll();

        if(isset($email['params']['theme'])) {
            $helper_themes =& WYSIJA::get('themes', 'helper');
            $themeDivider = $helper_themes->getDivider($email['params']['theme']);
            if($themeDivider !== NULL) {
                array_unshift($dividers, $themeDivider);
            }
        }

        if(isset($email['params']['divider'])) {
            $selected_divider = $email['params']['divider'];
        } else {
            $helper_dividers =& WYSIJA::get('dividers', 'helper');
            $selected_divider = $helper_dividers->getDefault();
        }

        array_unshift($dividers, $selected_divider);

        for($i = 1; $i < count($dividers); $i++) {
            if($dividers[$i]['src'] === $selected_divider['src']) {
                unset($dividers[$i]);
                break;
            }
        }
        $this->data['selected'] = $selected_divider;
        $this->data['dividers'] = $dividers;
        return $this->popupContent();
    }
    function autopost() {
        $this->iframeTabs=array('autopost'=>__("Add / Edit group of posts", WYSIJA));
        $this->js[]='wysija-admin-ajax';
        $this->js[]='wysija-base64';
        $this->js[]='wysija-colorpicker';
        $_GET['tab'] = 'autopost';

        $params = array(
            'category_ids' => null,
            'category' => null,
            'title_tag' => 'h2',
            'title_alignment' => 'left',
            'image_alignment' => 'alternate',
            'post_content' => 'excerpt',
            'readmore' => __('Read more.', WYSIJA),
            'show_divider' => 'yes',
            'post_limit' => 5,
            'cpt' => 'post',
            'nopost_message' => __('Latest content already sent.', WYSIJA),
            'bgcolor1' => null,
            'bgcolor2' => null
        );

        foreach($params as $key => $value) {
            if(array_key_exists($key, $_GET)) {
                switch($key) {
                    case 'autopost_count':
                        $params[$key] = (int)$_GET[$key];
                        break;
                    case 'readmore':
                    case 'nopost_message':
                        $params[$key] = base64_decode($_GET[$key]);
                        break;
                    default:
                        $params[$key] = $_GET[$key];
                }
            }
        }

        $this->data['autopost_count'] = (array_key_exists('autopost_count', $_GET)) ? (int)$_GET['autopost_count'] : 0;

        $this->data['autopost_type'] = (array_key_exists('autopost_type', $_GET)) ? $_GET['autopost_type'] : 'multiple';

        if($this->data['autopost_type'] === 'single') {
            if($params['image_alignment'] === 'alternate') $params['image_alignment'] = 'left';
        }

        $post_categories = get_categories(array('hide_empty' => 0));
        $categories = array();
        foreach($post_categories as $category) {
            $categories[] = array('id' => $category->cat_ID, 'name' => $category->name);
        }
        $this->data['categories'] = $categories;

        $this->data['post_limits'] = array(1,2,3,4,5,6,7,8,9,10,20,30,50);
        $this->data['params'] = $params;
        return $this->popupContent();
    }
    function image_data() {
        $this->data['url'] = (isset($_GET['url']) && $_GET['url'] !== '') ? trim(urldecode($_GET['url'])) : null;
        $this->data['alt'] = (isset($_GET['alt'])) ? trim(urldecode($_GET['alt'])) : '';
        $this->iframeTabs =array('image_data'=>__("Image Parameters",WYSIJA));
        $_GET['tab']='image_data';
        return $this->popupContent();
    }
    function medias(){
       $this->popupContent();
    }
    function special_wysija_browse() {
        $this->_wysija_subaction();
        $this->jsTrans['deleteimg']=__('Delete image for all newsletters?',WYSIJA);
        return wp_iframe( array($this->viewObj,'popup_wysija_browse'), array() );
    }
    function special_wordp_browse() {
        $this->_wysija_subaction();
        $this->jsTrans['deleteimg']=__('This image might be in an article. Delete anyway?',WYSIJA);
        return wp_iframe( array($this->viewObj,'popup_wp_browse'), array() );
    }

    function _wysija_subaction() {
        if(isset($_REQUEST['subaction'])){
            if($_REQUEST['subaction'] === 'delete') {
                if(isset($_REQUEST['imgid']) && (int)$_REQUEST['imgid'] > 0){
                    
                     $res = wp_delete_attachment((int)$_REQUEST['imgid'], true);
                     if($res) {
                         $this->notice(__('Image has been deleted.', WYSIJA));
                     }
                }
            }
        }
        return true;
    }
    function special_new_wordp_upload() {

        wp_enqueue_script('wysija-plupload-handlers', WYSIJA_URL.'js/jquery/pluploadHandler.js', array('plupload-all', 'jquery'));
        $uploader_l10n = array(
		'queue_limit_exceeded' => __('You have attempted to queue too many files.'),
		'file_exceeds_size_limit' => __('%s exceeds the maximum upload size for this site.'),
		'zero_byte_file' => __('This file is empty. Please try another.'),
		'invalid_filetype' => __('This file type is not allowed. Please try another.'),
		'not_an_image' => __('This file is not an image. Please try another.'),
		'image_memory_exceeded' => __('Memory exceeded. Please try another smaller file.'),
		'image_dimensions_exceeded' => __('This is larger than the maximum size. Please try another.'),
		'default_error' => __('An error occurred in the upload. Please try again later.'),
		'missing_upload_url' => __('There was a configuration error. Please contact the server administrator.'),
		'upload_limit_exceeded' => __('You may only upload 1 file.'),
		'http_error' => __('HTTP error.'),
		'upload_failed' => __('Upload failed.'),
		'big_upload_failed' => __('Please try uploading this file with the %1$sbrowser uploader%2$s.'),
		'big_upload_queued' => __('%s exceeds the maximum upload size for the multi-file uploader when used in your browser.'),
		'io_error' => __('IO error.'),
		'security_error' => __('Security error.'),
		'file_cancelled' => __('File canceled.'),
		'upload_stopped' => __('Upload stopped.'),
		'dismiss' => __('Dismiss'),
		'crunching' => __('Crunching&hellip;'),
		'deleted' => __('moved to the trash.'),
		'error_uploading' => __('&#8220;%s&#8221; has failed to upload.')
	);
        wp_localize_script('wysija-plupload-handlers', 'pluploadL10n', $uploader_l10n);
        wp_enqueue_script('image-edit');
        wp_enqueue_script('set-post-thumbnail' );
        wp_enqueue_style('imgareaselect');
        wp_enqueue_script( 'media-gallery' );
        

        $errors=array();
        return wp_iframe( array($this->viewObj,'popup_new_wp_upload'), $errors );
    }
    function special_wordp_upload() {
        wp_enqueue_script('swfupload-all');
        wp_enqueue_script('swfupload-handlers');
        wp_enqueue_script('wysija-upload-handlers',WYSIJA_URL."js/jquery/uploadHandlers.js");
        wp_enqueue_script('image-edit');
        wp_enqueue_script('set-post-thumbnail' );
        wp_enqueue_style('imgareaselect');
        $errors = array();
	$id = 0;
        if(isset($_GET['flash']))$_GET['flash']=1;
	if ( isset($_POST['html-upload']) && !empty($_FILES) ) {

		$id = media_handle_upload('async-upload', $_REQUEST['post_id']);
		unset($_FILES);
		if ( is_wp_error($id) ) {
			$errors['upload_error'] = $id;
			$id = false;
		}
	}
	if ( !empty($_POST['insertonlybutton']) ) {
		$href = $_POST['insertonly']['href'];
		if ( !empty($href) && !strpos($href, '://') )
			$href = "http://$href";
		$title = esc_attr($_POST['insertonly']['title']);
		if ( empty($title) )
			$title = basename($href);
		if ( !empty($title) && !empty($href) )
			$html = "<a href='" . esc_url($href) . "' >$title</a>";
		$html = apply_filters('file_send_to_editor_url', $html, esc_url_raw($href), $title);
		return media_send_to_editor($html);
	}
	if ( !empty($_POST) ) {
		$return = media_upload_form_handler();
		if ( is_string($return) )
			return $return;
		if ( is_array($return) )
			$errors = $return;
	}
	if ( isset($_POST['save']) ) {
		$errors['upload_notice'] = __('Saved.',WYSIJA);
		return media_upload_gallery();
	}

        return wp_iframe( array($this->viewObj,'popup_wp_upload'), $errors );
    }
    function _checkEmailExists($emailId){
        $result=false;
        $modelEmail=&WYSIJA::get('email','model');
        if($modelEmail->exists(array('email_id'=>$emailId))) $result= true;
        if(!$result){
            $this->error(__("The newsletter doesn't exist.",WYSIJA),1);
            $this->redirect('admin.php?page=wysija_campaigns');
        }else return true;
    }

    function install_wjp(){
        $premiumpluginname='wysija-newsletters-premium/index.php';
        echo '<html><head></head><body style="font-family: sans-serif;font-size: 12px;line-height: 1.4em;">';
        if(WYSIJA::is_plugin_active($premiumpluginname)){
            echo '<p>'.__('Plugin is already installed and activated.',WYSIJA).'</p>';
            exit;
        }

        $pluginslist=get_plugins();
        if(isset($pluginslist[$premiumpluginname])){

            error_reporting(E_ALL);
            ini_set('display_errors', '1');
            activate_plugin($premiumpluginname);
            echo '<p>'.__('Your Premium features are now activated. Happy emailing!',WYSIJA).'</p>';
        }else{

            include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            include_once WYSIJA_INC . 'wp-special'.DS.'wp-upgrader-skin.php';
            $upgrader = new Plugin_Upgrader( new WysijaPlugin_Upgrader_Skin( compact('title', 'url', 'nonce', 'plugin', 'api') ));
            $response=$upgrader->install('http://packager.wysija.com/download/zip?key=wysija-newsletters-premium');
        }
        echo '</body></html>';
        exit;
    }
}
