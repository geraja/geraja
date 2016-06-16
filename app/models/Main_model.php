<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_model extends CI_Model {

  public function get_item($table = null, $where = null, $select_only = null, $join_table = null, $join_where = null)
  {
    if($table) {
      if(is_array($where)) $this->db->where($where);

      if($select_only) {
        $this->db->select($select_only);
      }

      if($join_table && $join_where) {
        $this->db->join($join_table, $join_where, 'left');
      }


      $query = $this->db->get($table);

      if($query->num_rows()) return $query->row_array();
      else return false;
    }

    return null;
  }

  public function get_items($table = null, $where = null, $limit = 100, $offset = 0, $order_field = null, $order = 'asc', $search_fields = null)
  {
    if($table) {
      if(is_array($where)) $this->db->where($where);

      if($order_field) $this->db->order_by($order_field, $order);

      if(is_array($search_fields)) {
        foreach ($search_fields as $field => $search_string) {
          if($field && $search_string) {
            $this->db->like($field, $search_string);
          }
        }
      }

      $query = $this->db->get($table, $limit, $offset);

      if($query->num_rows()) return $query->result();
      else return false;
    }

    return null;
  }

  public function update_item($table = null, $where = null, $data = null)
  {
    if($table && is_array($where) && is_array($data)) {
      $this->db->where($where);
      $query = $this->db->update($table, $data);

      if(sizeof($query)) {
        return true;
      } else {
        return false;
      }
    }

    return null;
  }

  public function delete_item($table = null, $where = null)
  {
    if($table && is_array($where)) {
      $this->db->where($where);
      $query = $this->db->delete($table);

      if(sizeof($query)) {
        return true;
      } else {
        return false;
      }
    }

    return null;
  }

  public function insert_item($table = null, $data = null)
  {
    if($table && is_array($data)) {

      $this->db->insert($table, $data);

      if($this->db->affected_rows()) {
        return $this->db->insert_id();
      } else {
        return false;
      }
    }

    return null;
  }

  public function get_last_uid()
  {
    $this->db->select('uid');
    $this->db->order_by('uid', 'desc');
    $query = $this->db->get('users', 1);

    if($query->num_rows()) {
      $user = $query->result_array();
      $last_uid = $user[0]['uid'] + 1;
      return $last_uid;
    } else {
      return 1;
    }
  }

  public function get_last_id_game()
  {
    $this->db->select('id_game');
    $this->db->order_by('id_game', 'desc');
    $query = $this->db->get('games', 1);

    if($query->num_rows()) {
      $game = $query->result_array();
      $last_uid = $game[0]['id_game'] + 1;
      return $last_uid;
    } else {
      return 1;
    }
  }

  public function get_game_questions($where = null, $limit = 100, $offset = 0, $order_field = null, $order = 'asc')
  {
    if(is_array($where)) $this->db->where($where);
    if($order_field) $this->db->order_by($order_field, $order);

    $this->db->select('game_questions.*, assets.name AS name');

    $this->db->join('assets', 'assets.id_asset = game_questions.id_asset', 'left');

    $query = $this->db->get('game_questions', $limit, $offset);

    if($query->num_rows()) return $query->result();
    else return false;
  }

  public function get_total_items($table = null, $where = null){
    if(is_array($where)) $this->db->where($where);

    $query = $this->db->get($table);
    return $query->num_rows();
  }
}

/* End of file main_model.php */
/* Location: .home/isanio/projetos/gerador-de-jogos/app/models/main_model.php */
