<?php
$this->pageTitle = 'Hilfetexte | ' . Yii::app()->name;
$this->breadcrumbs = array('Hilfetexte');
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/hints.js"></script>

<div ng-controller="HintsController" class="wraper container-fluid" ng-cloak>
	<div class="row">
		<div class="container center-block">
			<div spi-hint-main header="_hint.header.title" text="_hint.header.text"></div>
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h1 class="panel-title col-lg-6">Hilfetexte</h1>
					<div class="pull-right heading-box-print">
            <a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
            <button class="custom-btn btn w-xs" export-to-csv ng-click="">csv Export</button>
						<button class="btn w-lg custom-btn" ng-if="canEdit()" ng-click="openEdit()">Hilfetext hinzufügen/bearbeiten</button>
					</div>
				</div>
				<div class="panel-body hint-edit">
					<div class="row datafilter">
						<form>
							<div class="col-lg-5">
								<div class="form-group">
									<label>Seite</label>
									<ui-select ng-change="updateGrid()" ng-model="filter.page_id">
										<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
										<ui-select-choices repeat="item.id as item in pages | filter: $select.search | orderBy: 'name'">
											<span ng-bind-html="item.name | highlight: $select.search"></span>
										</ui-select-choices>
									</ui-select>
								</div>
							</div>
							<div class="col-lg-5">
								<div class="form-group">
									<label>Position</label>
									<input ng-change="updateGrid()" type="search" ng-model="filter.position" class="form-control" placeholder="Position eingeben">
								</div>
							</div>
							<div class="col-lg-2">
								<button ng-click="resetFilter()" class="btn w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
							</div>
						</form>
					</div>

					<table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
						<tr ng-repeat="row in $data">
							<td data-title="'Seite'" sortable="'page_name'">{{row.page_name}}</td>
							<td data-title="'Position'" sortable="'position_name'">{{row.position_name}}</td>
              <td data-title="'Titel'">{{row.title}}</td>
							<td data-title="'Hilfetext'">{{row.description}}</td>
              <td data-title="'Ansicht / Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
                <a class="btn center-block edit-btn" ng-click="openEdit(row, !canEdit())">
                  <i class="ion-eye"  ng-if="!canEdit()"></i>
                  <i class="ion-edit" ng-if="canEdit()"></i>
                </a>
              </td>
						</tr>
            <tr ng-if="!$data.length"><td class="no-result" colspan="4">Keine Ergebnisse</td></tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/ng-template" id="editTemplate.html">
	<div class="panel panel-color panel-primary">
		<div class="panel-heading clearfix">
			<h3 ng-if="isInsert" class="m-0 pull-left">Hilfetext hinzufügen/bearbeiten</h3>
			<h3 ng-if="!isInsert && !modeView" class="m-0 pull-left">Hilfe bearbeiten  #{{hintId}}</h3>
			<h3 ng-if="!isInsert && modeView" class="m-0 pull-left">Hilfe ansicht #{{hintId}}</h3>
			<button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
		</div>
		<div class="panel-body">
			<form novalidate name="form" class="form-horizontal" disable-all="modeView || !canEdit()">
				<div class="form-group">
					<label class="col-lg-2 control-label">Seite</label>
					<div ng-if="!isInsert" class="col-lg-10">
						<span class="no-edit-text">{{page_name}}</span>
						<span spi-hint text="_hint.page_id.text"  title="_hint.page_id.title" ></span>
					</div>
					<div ng-if="isInsert" class="col-lg-10">
						<span spi-hint text="_hint.page_id.text"  title="_hint.page_id.title"  class="has-hint"></span>
						<div class="wrap-hint" ng-class="{'wrap-line error': fieldError('page_id')}">
							<ui-select ng-change="changePage()" ng-model="hint.page_id" name="page_id" required>
								<ui-select-match placeholder="(Bitte wählen Sie)">{{$select.selected.name}}</ui-select-match>
								<ui-select-choices repeat="item.id as item in pages | filter: $select.search">
									<span ng-bind-html="item.name | highlight: $select.search"></span>
								</ui-select-choices>
							</ui-select>
							<span ng-class="{hide: !fieldError('page_id')}" class="hide">
								<label ng-show="form.page_id.$error.required" class="error">Seite ist erforderlich</label>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group" ng-if="(isInsert && hint.page_id) || !isInsert">
					<label class="col-lg-2 control-label">Position</label>
					<div ng-if="!isInsert" class="col-lg-10">
						<span class="no-edit-text">{{position_name}}</span>
						<span spi-hint text="_hint.position_id.text"  title="_hint.position_id.title" ></span>
					</div>
					<div ng-if="isInsert && hint.page_id" class="col-lg-10">
						<span spi-hint text="_hint.position_id.text"  title="_hint.position_id.title"  class="has-hint"></span>
						<div class="wrap-hint" ng-class="{'wrap-line error': fieldError('position_id')}">
							<ui-select ng-disabled="!$select.items.length" ng-change="changePosition(hint.position_id)" ng-model="hint.position_id" name="position_id" required>
								<ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' :'(Bitte wählen Sie)'}}">{{$select.selected.name}}</ui-select-match>
								<ui-select-choices repeat="item.id as item in positions | filter: $select.search">
									<span ng-bind-html="item.name | highlight: $select.search"></span>
								</ui-select-choices>
							</ui-select>
							<span ng-class="{hide: !fieldError('position_id')}" class="hide">
								<label ng-show="form.position_id.$error.required" class="error">Position ist erforderlich</label>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group" ng-if="showTitle">
					<label class="col-lg-2 control-label">Titel</label>
					<div class="col-lg-10">
						<span spi-hint text="_hint.title.text"  title="_hint.title.title"  class="has-hint"></span>
						<div class="wrap-hint" ng-class="{'wrap-line error': fieldError('title')}">
							<textarea ng-model="hint.title" ng-minlength="3" maxlength="255" name="title" class="form-control" rows="5" required></textarea>
							<span ng-class="{hide: !fieldError('title')}" class="hide">
								<label ng-show="form.title.$error.required" class="error">Titel ist erforderlich</label>
								<label ng-show="form.title.$error.minlength" class="error">Titel ist zu kurz</label>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Hilfetext</label>
					<div class="col-lg-10">
						<span spi-hint text="_hint.description.text"  title="_hint.description.title"  class="has-hint"></span>
						<div class="wrap-hint" ng-class="{'wrap-line error': fieldError('description')}">
							<textarea ng-model="hint.description" name="description" ng-minlength="3" maxlength="{{!showTitle ? 255 : 65000}}" class="form-control" rows="7" required></textarea>
							<span ng-class="{hide: !fieldError('description')}" class="hide">
								<label ng-show="form.description.$error.required" class="error">Hilfetext ist erforderlich</label>
								<label ng-show="form.description.$error.minlength" class="error">Hilfetext ist zu kurz</label>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group group-btn p-t-10">
					<div class="col-lg-2" ng-if="!isInsert && !modeView && canEdit()">
						<a ng-click="remove()" class="btn btn-icon btn-danger btn-lg sweet-4"><i class="fa fa-trash-o"></i></a>
					</div>
					<div class="col-lg-6 text-right pull-right">
						<button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
						<button class="btn w-lg custom-btn" ng-if="!modeView && canEdit()" ng-click="submitForm(hint)">Speichern</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</script>