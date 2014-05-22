<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

/**
 * This is the model class for table "et_ophtroperationnote_cataract".
 *
 * The followings are the available columns in table 'et_ophtroperationnote_cataract':
 * @property integer $id
 * @property integer $event_id
 * @property integer $incision_site_id
 * @property string $length
 * @property string $meridian
 * @property integer $incision_type_id
 * @property string $eyedraw
 * @property string $report
 * @property integer $iol_position_id
 * @property string $complication_notes
 * @property string $eyedraw2
 * @property string $iol_power
 * @property integer $iol_type_id
 * @property string $report2
 *
 * The followings are the available model relations:
 * @property Event $event
 * @property OphTrOperationnote_IncisionType $incision_type
 * @property OphTrOperationnote_IncisionSite $incision_site
 * @property OphTrOperationnote_IOLPosition $iol_position
 * @property OphTrOperationnote_CataractComplication[] $complication_assignments
 * @property OphTrOperationnote_CataractComplications[] $complicationItems
 * @property OphTrOperationnote_CataractOperativeDevice[] $operative_device_assigments
 * @property OperativeDevice[] $operative_devices
 * @property OphTrOperationnote_IOLType $iol_type
 */
class Element_OphTrOperationnote_Cataract extends Element_OnDemand
{
	public $service;

	public $predicted_refraction = null;
	public $auto_update_relations = true;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Element_OphTrOperationnote_Cataract the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'et_ophtroperationnote_cataract';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, incision_site_id, length, meridian, incision_type_id, iol_position_id, iol_type_id, iol_power, eyedraw, report, complication_notes, eyedraw2, report2, predicted_refraction, complications, operative_devices', 'safe'),
			array('incision_site_id, length, meridian, incision_type_id, predicted_refraction, iol_position_id, eyedraw, report, eyedraw2', 'required'),
			array('length', 'numerical', 'integerOnly' => false, 'numberPattern' => '/^[0-9](\.[0-9])?$/', 'message' => 'Length must be 0 - 9.9 in increments of 0.1'),
			array('meridian', 'numerical', 'integerOnly' => false, 'numberPattern' => '/^[0-9]{1,3}(\.[0-9])?$/', 'min' => 000, 'max' => 360, 'message' => 'Meridian must be 000.5 - 360.0 degrees'),
			array('predicted_refraction', 'numerical', 'integerOnly' => false, 'numberPattern' => '/^\-?[0-9]{1,2}(\.[0-9]{1,2})?$/', 'min' => -30, 'max' => 30, 'message' => 'Predicted refraction must be between -30.00 and 30.00'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, event_id, incision_site_id, length, meridian, incision_type_id, eyedraw, report, wound_burn, iris_trauma, zonular_dialysis, pc_rupture, decentered_iol, iol_exchange, dropped_nucleus, op_cancelled, corneal_odema, iris_prolapse, zonular_rupture, vitreous_loss, iol_into_vitreous, other_iol_problem, choroidal_haem', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'incision_type' => array(self::BELONGS_TO, 'OphTrOperationnote_IncisionType', 'incision_type_id'),
			'incision_site' => array(self::BELONGS_TO, 'OphTrOperationnote_IncisionSite', 'incision_site_id'),
			'iol_position' => array(self::BELONGS_TO, 'OphTrOperationnote_IOLPosition', 'iol_position_id'),
			'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			'complication_assignments' => array(self::HAS_MANY, 'OphTrOperationnote_CataractComplication', 'cataract_id'),
			'complications' => array(self::HAS_MANY, 'OphTrOperationnote_CataractComplications', 'complication_id',
				'through' => 'complication_assignments'),
			'operative_device_assignments' => array(self::HAS_MANY, 'OphTrOperationnote_CataractOperativeDevice', 'cataract_id'),
			'operative_devices' => array(self::HAS_MANY, 'OperativeDevice', 'operative_device_id',
				'through' => 'operative_device_assignments'),
			'iol_type' => array(self::BELONGS_TO, 'OphTrOperationnote_IOLType', 'iol_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'incision_site_id' => 'Incision site',
			'incision_type_id' => 'Incision type',
			'iol_position_id' => 'IOL position',
			'iol_power' => 'IOL power',
			'iol_type_id' => 'IOL type',
			'length' => 'Length',
			'meridian' => 'Meridian',
			'report' => 'Details',
			'complication_notes' => 'Complication notes',
			'report2' => 'Details',
			'predicted_refraction' => 'Predicted refraction',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('event_id', $this->event_id, true);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
			));
	}

	/**
	 * Set default values for forms on create
	 */
	public function setDefaultOptions()
	{
		if (Yii::app()->controller->selectedEyeForEyedraw->id == 1) {
			$this->meridian = 0;
		}
	}

	/**
	 * Need to delete associated records
	 * @see CActiveRecord::beforeDelete()
	 */
	protected function beforeDelete()
	{
		OphTrOperationnote_CataractComplication::model()->deleteAllByAttributes(array('cataract_id' => $this->id));
		OphTrOperationnote_CataractOperativeDevice::model()->deleteAllByAttributes(array('cataract_id' => $this->id));
		return parent::beforeDelete();
	}

	/**
	 * The eye of the procedure is stored in the parent procedure list element
	 *
	 * @return Eye
	 */
	public function getEye()
	{
		return Element_OphTrOperationnote_ProcedureList::model()->find('event_id=?',array($this->event_id))->eye;
	}

	/**
	 * Validate IOL data if IOL is part of the element
	 *
	 * @return bool
	 */
	public function beforeValidate()
	{
		$iol_position = OphTrOperationnote_IOLPosition::model()->findByPk($this->iol_position_id);

		if (!$iol_position || $iol_position->name != 'None') {
			if (!$this->iol_type_id) {
				$this->addError('Cataract','IOL type cannot be blank');
			}
			if (!$this->iol_power) {
				$this->addError('Cataract','IOL power cannot be blank');
			} elseif (!preg_match('/^\-?[0-9]{1,3}(\.[0-9])?$/',$this->iol_power)) {
				$this->addError('Cataract','IOL power must be a number with an optional single decimal place between -999.9 and 999.9');
			}
		}

		return parent::beforeValidate();
	}

	/**
	 * Check the eye draw for any IOL elements. If there is one, IOL fields should not be hidden
	 *
	 * @return bool
	 */
	public function getIol_hidden()
	{
		if ($eyedraw = @json_decode($this->eyedraw)) {
			if (is_array($eyedraw)) {
				foreach ($eyedraw as $object) {
					if (in_array($object->subclass,Yii::app()->params['eyedraw_iol_classes'])) {
						return false;
					}
				}
				return true;
			}
		}

		return false;
	}

	/**
	 * Get ids of cataract complications associated with the element
	 */
	public function getCataractComplicationValues()
	{
		$complication_values = array();

		foreach ($this->complication_assignments as $complication_assignment) {
			$complication_values[] = $complication_assignment->complication_id;
		}

		return $complication_values;
	}
}
