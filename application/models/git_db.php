<?php 

class Git_db extends CI_Model { 

	function __construct()
    {
        // 呼叫模型(Model)的建構函數
        parent::__construct();
    }

    function insert($data){
	
		$this->db->insert('rma_detail', $data);
	}

	function insert_comment($data){
	
		$this->db->insert('rma_comment', $data);
	}

	function get_detail(){
	
		$query = $this->db->order_by('submit_date', 'desc')->get('rma_detail'); 
		return $query->result();
		
	}

	function get_detail_open(){
	
		$query = $this->db->order_by('submit_date', 'desc')
						  ->where('status','open')
						  ->get('rma_detail'); 
		return $query->result();
		
	}

	function get_detail_close(){
	
		$query = $this->db->order_by('submit_date', 'desc')
						  ->where('status','close')
						  ->get('rma_detail'); 
		return $query->result();
		
	}

	function get_detail_all($id){
	
		$query = $this->db->get_where('rma_detail',array('id'=>$id));
		return $query->result();        

	}

	function update($data) {
		
		$this->db->where('id', $this->input->post('id'));
		$this->db->update('rma_detail',$data);
	}

	
	function get_calendar_data($year, $month) {
        $events = array();
        $query = $this->db->select('demand_date, form_num')
                          ->like('demand_date',"$year-$month")
                          ->get('rma_detail');
        foreach ($query->result() as $row) {
            $day = (int)substr($row->demand_date, 8,2);
            $events[(int)$day] = $row->form_num;
        }
        return $events;
    } 

	function generate_calendar($year,$month) {

		$prefs = array (
        'start_day'    => 'monday',
        'month_type'   => 'long',
        'day_type'     => 'short',
        'show_next_prev'  => TRUE,
        'next_prev_url'   => base_url().'manage/display_cal'
             );

        
        $prefs['template'] = '
         {table_open}<table>{/table_open}

         {heading_row_start}<tr>{/heading_row_start}

         {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
         {heading_title_cell}<th colspan="{colspan}" class="row_start">{heading}</th>{/heading_title_cell}
         {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

         {heading_row_end}</tr>{/heading_row_end}

         {week_row_start}<tr>{/week_row_start}
         {week_day_cell}<td class="row_start">{week_day}</td>{/week_day_cell}
         {week_row_end}</tr>{/week_row_end}

         {cal_row_start}<tr>{/cal_row_start}
         {cal_cell_start}<td>{/cal_cell_start}

         {cal_cell_content}
         	<div>{day}</div>
         	<div>
         	{content}
         	</div>
         {/cal_cell_content}
         {cal_cell_content_today}<div class="highlight">
         	<div>{day}</div>
         	<div>{content}</div>
         </div>{/cal_cell_content_today}

         {cal_cell_no_content}{day}{/cal_cell_no_content}
         {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

         {cal_cell_blank}&nbsp;{/cal_cell_blank}

         {cal_cell_end}</td>{/cal_cell_end}
         {cal_row_end}</tr>{/cal_row_end}

         {table_close}</table>{/table_close}';

	    $this->load->library('calendar', $prefs);
	    $cal_data = $this->get_calendar_data($year,$month);
    	return $this->calendar->generate($year, $month, $cal_data);
	}

}

?>