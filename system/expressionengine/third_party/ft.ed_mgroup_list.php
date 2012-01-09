<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ED Member Group List field type
 *
 * @package     ED_Mgroup_list
 * @version     1.1.0
 * @author      Wil Linssen (Erskine Design)
 * @copyright   Copyright (c) 2012 Erskine Design
 * @license     http://creativecommons.org/licenses/by-sa/3.0/ Attribution-Share Alike 3.0 Unported
 */
class ED_mgroup_list_ft extends EE_Fieldtype
{

    /**
     * Field info
     *
     * @access  public
     * @var     array
     */
    public $info = array(
        'name' => 'ED Member Group List',
        'version' => '1.1.0'
    );

    /**
     * EE instance
     *
     * @access  private
     * @var     object
     */
    private $_EE;

    /**
     * Member groups
     *
     * @access  private
     * @var     array
     */
    private $_member_groups;

    /**
     * Constructor
     *
     * @access  public
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display field
     *
     * @access  public
     * @param   $data Current field data
     */
    public function display_field($data)
    {
        $this->_get_member_groups();
        return form_dropdown($this->field_name, $this->_member_groups, $data);
    }

    /**
     * Display cell (for Matrix)
     *
     * @access  public
     * @param   $data Current field data
     */
    public function display_cell($data)
    {
        $this->_get_member_groups();
        return form_dropdown($this->cell_name, $this->_member_groups, $data);
    }


    /**
     * Get member groups
     *
     * @access private
     */
    private function _get_member_groups()
    {
        // Get EE instance
        $this->_EE =& get_instance();

        // Fetch member groups
        $query = $this->_EE->db
            ->select(array('group_id', 'group_title'))
            ->from('member_groups')
            ->where('site_id', $this->_EE->config->item('site_id'))
            ->get();

        foreach ($query->result_array() as $row)
        {
            $this->_member_groups[$row['group_id']] = $row['group_title'];
        }

    }

}
/* End of file ft.ed_mgroup_list.php */
