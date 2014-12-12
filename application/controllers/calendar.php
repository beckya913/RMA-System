<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	

	public function display($year=null, $month=null)
	{
		
		$prefs = array (
        'start_day'    => 'monday',
        'month_type'   => 'long',
        'day_type'     => 'short',
        'show_next_prev'  => TRUE,
        'next_prev_url'   => base_url().'calendar/display'
             );

        $prefs['template'] = '
         {table_open}<table border="0" cellpadding="0" cellspacing="0">{/table_open}

         {heading_row_start}<tr>{/heading_row_start}

         {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
         {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
         {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

         {heading_row_end}</tr>{/heading_row_end}

         {week_row_start}<tr>{/week_row_start}
         {week_day_cell}<td>{week_day}</td>{/week_day_cell}
         {week_row_end}</tr>{/week_row_end}

         {cal_row_start}<tr>{/cal_row_start}
         {cal_cell_start}<td>{/cal_cell_start}

         {cal_cell_content}
         	<div>{day}</div>
         	<div>{content}</div>
         {/cal_cell_content}
         {cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}

         {cal_cell_no_content}{day}{/cal_cell_no_content}
         {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

         {cal_cell_blank}&nbsp;{/cal_cell_blank}

         {cal_cell_end}</td>{/cal_cell_end}
         {cal_row_end}</tr>{/cal_row_end}

         {table_close}</table>{/table_close}';

	    $this->load->library('calendar', $prefs);
	    $cal_data = array(
	        15 => 'foo',
	        17 => 'bar'
	       );

    	$data['calendar'] = $this->calendar->generate($year, $month, $cal_data);
    	$this->load->view('mycal', $data);

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */