<nav class="navbar navbar-default header-nav m-b-0">
	<div class="container-fluid">
		<ul class="nav navbar-nav">
			<li ng-class="{'active': _m=='dashboard'}"><a href="/dashboard">Главная</a></li>
			<!--<li><a href="/request-list.php">Anträge</a></li>-->
      <li><a href="/requests">Заказы</a></li>
      <li><a href="/requests">Изделия</a></li>
      <li><a href="/requests">Расчеты</a></li>
      <li><a href="/requests">Договора</a></li>
      <?php if(safe(Yii::app()->session['rights']['summary'], 'show') ||
               safe(Yii::app()->session['rights']['financial-request'], 'show') ||
               safe(Yii::app()->session['rights']['finance-report'], 'show') ||
               safe(Yii::app()->session['rights']['finance-source'], 'show')): ?>
			<li ng-class="{'active': ['finance_source'].indexOf(_m) !== -1}" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Взаиморасчеты</a>
				<ul class="dropdown-menu">
          <?php if(safe(Yii::app()->session['rights']['summary'], 'show')):?>
					<li><a href="/summary">Приходы</a></li>
          <?php endif; ?>
          <?php if(safe(Yii::app()->session['rights']['financial-request'], 'show')):?>
					  <li ng-hide="user.type == 't' && user.is_finansist == 0"><a href="/financial-request">Расходы</a></li>
          <?php endif; ?>
          <?php if(safe(Yii::app()->session['rights']['finance-report'], 'show')):?>
					  <li><a href="/finance-report">Belege</a></li>
          <?php endif; ?>
          <?php if(safe(Yii::app()->session['rights']['finance-source'], 'show')): ?>
					  <li><a href="/finance-source">Fördertöpfe</a></li>
          <?php endif; ?>
				</ul>
			</li>
      <?php endif; ?>
      <?php if(safe(Yii::app()->session['rights']['projects'], 'show')): ?>
      <?php endif; ?>      
			<li ng-class="{'active': ['performer', 'school', 'district'].indexOf(_m) !== -1}" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Справочники</a>
				<ul class="dropdown-menu">
          <?php if(safe(Yii::app()->session['rights']['users'], 'show')): ?>
            <li><a href="/users">Список пользователей</a></li>
          <?php endif; ?>
          <?php if(safe(Yii::app()->session['rights']['user-roles'], 'show')): ?>
            <li><a href="/user-roles">Права доступа</a></li>
          <?php endif; ?>
          <?php if(safe(Yii::app()->session['rights']['performers'], 'show')): ?>  
					  <li><a href="/performers">Отделы продаж</a></li>
          <?php endif; ?>  
          <?php if(safe(Yii::app()->session['rights']['schools'], 'show')): ?>
					  <li><a href="/schools">Номенклатура МЦ</a></li>
          <?php endif; ?>  
          <?php if(safe(Yii::app()->session['rights']['districts'], 'show')): ?>          
					  <li><a href="/districts">Bezirk</a></li>
          <?php endif; ?>

				</ul>
			</li>

      <?php if(safe(Yii::app()->session['rights']['document-templates'], 'show') || 
               safe(Yii::app()->session['rights']['hints'], 'show') || 
               safe(Yii::app()->session['rights']['email-templates'], 'show') || 
               safe(Yii::app()->session['rights']['audit'], 'show')): ?>
			<li ng-class="{'active': ['hint'].indexOf(_m) !== -1}" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Система управления</a>
				<ul class="dropdown-menu">
          <?php if(Yii::app()->session['rights']['document-templates']['show']): ?>
            <li><a href="/document-templates">Шаблоны документов</a></li>
          <?php endif; ?>
          <?php if(Yii::app()->session['rights']['hints']['show']): ?>
					  <li><a href="/hints">Подсказки</a></li>
          <?php endif; ?>
          <?php if(Yii::app()->session['rights']['email-templates']['show']): ?>          
            <li><a href="/email-templates">E-Mail-Vorlagen</a></li>
          <?php endif; ?>
          <?php if(Yii::app()->session['rights']['audit']['show']): ?>
					  <li><a href="/audit">Audit</a></li>
          <?php endif; ?>
				</ul>
			</li>
      <?php endif; ?>
			<li><a href="/contact">Контакты</a></li>
		</ul>
	</div>   
</nav>