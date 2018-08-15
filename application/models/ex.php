            public function getDashboardById(){
        if ($this->session->userdata('user_login_access') != False) {
            $id                 = $this->input->get('id');
            //$tcur                = $this->input->post('tcur');
            $data['dashboard'] = $this->dashboard_model->getDashboardBYID($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
SELECT a.codes, b.buy_rate, b.sell_rate FROM currency_code a, currency_rate b 
WHERE b.currency_id = a.currency_id 
AND a.codes = 'MMK'
ORDER BY a.codes, b.date DESC
LIMIT 1


 WHERE `currency_rate`.`currency_id` = `currency_code`.`currency_id`
AND `currency_code`.`codes` = `MMK`
                ORDER BY `currency_code`.`codes`, `currency_rate`.`date` DESC
                LIMIT `1`";