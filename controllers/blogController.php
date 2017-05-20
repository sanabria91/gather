<?php

class Blog
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function listBlog()
    {
        $query = "SELECT * FROM blog";
        $pdostmt = $this->db->prepare($query);
        $pdostmt->execute();
        $list = $pdostmt->fetchAll(PDO::FETCH_OBJ);
        return $list;
    }

    public function blogDetails($id)
    {
        $query1 = "SELECT * FROM blog
                    WHERE id = :id ";
        $pdostmt1 = $this->db->prepare($query1);
        $pdostmt1->bindValue(':id',$id, PDO::PARAM_INT);
        $pdostmt1->execute();
        $details = $pdostmt1->fetch(PDO::FETCH_OBJ);
        return $details;
    }

    public function blogPost($date, $title, $content, $imgData)
    {
        $query2 = "INSERT INTO blog
                  (date, title, content, image)
                  VALUES(:date, :title, :content, :image)";
        $pdostmt2 = $this->db->prepare($query2);
        $pdostmt2->bindValue(':date', $date, PDO::PARAM_STR);
        $pdostmt2->bindValue(':title', $title, PDO::PARAM_STR);
        $pdostmt2->bindValue(':content', $content, PDO::PARAM_STR);
        $pdostmt2->bindValue(':image', $imgData, PDO::PARAM_STR);
        $add = $pdostmt2->execute();
        return $add;
    }

    public function deletePost($id)
    {
        $query4 = "DELETE FROM blog WHERE id = :id";
        $pdostmt4 = $this->db->prepare($query4);
        $pdostmt4->bindValue(':id',$id, PDO::PARAM_INT);
        $delete = $pdostmt4->execute();
        return $delete;
    }

    public function updateDetails($id, $date, $title, $content, $image)
    {
        if ($image ==  "")
        {
            $query5 = "UPDATE blog SET date = :date, title = :title, content = :content WHERE id = :id";
            $pdostmt5 = $this->db->prepare($query5);
        }
        else{
            $query5 = "UPDATE blog SET date= :date, title= :title, content= :content,
                    image= :image
                    WHERE id= :id";
            $pdostmt5 = $this->db->prepare($query5);
            $pdostmt5->bindValue(':image', $image, PDO::PARAM_STR);
        }
//        $query5 = "UPDATE blog SET date = :date, title = :title, content = :content,
//                    image= :image
//                    WHERE id= :id";
        $pdostmt5->bindValue(':id',intval($id), PDO::PARAM_INT);
        $pdostmt5->bindValue(':date', $date, PDO::PARAM_STR);
        $pdostmt5->bindValue(':title', $title, PDO::PARAM_STR);
        $pdostmt5->bindValue(':content', $content, PDO::PARAM_STR);

        $update = $pdostmt5->execute();
        return $update;
        /*
         * $query2 = "INSERT INTO blog
                  (date, title, content, image)
                  VALUES(:date, :title, :content, :image)";
        $pdostmt2 = $this->db->prepare($query2);
        $pdostmt2->bindValue(':date', $date, PDO::PARAM_STR);
        $pdostmt2->bindValue(':title', $title, PDO::PARAM_STR);
        $pdostmt2->bindValue(':content', $content, PDO::PARAM_STR);
        $pdostmt2->bindValue(':image', $imgData, PDO::PARAM_STR);
        $add = $pdostmt2->execute();
        return $add;
         * */
    }

    public function postMsg($user, $comment, $blog_id)
    {
        $query6 = "INSERT INTO comments
                    (username, comment, blog_id)
                    VALUES(:user, :comment, :blog_id)";
        $pdostmt6 = $this->db->prepare($query6);
        $pdostmt6->bindValue(':user',$user, PDO::PARAM_INT);
        $pdostmt6->bindValue(':comment',$comment, PDO::PARAM_STR);
        $pdostmt6->bindValue(':blog_id',$blog_id, PDO::PARAM_INT);
        $addMsg = $pdostmt6->execute();
        return $addMsg;
    }

    public function getComment($id)
    {
        $query7 = "     SELECT comments.* 
                          FROM comments
                    INNER JOIN blog
                            ON comments.blog_id = blog.id
                         WHERE blog.id = :id";
        $pdostmt7 = $this->db->prepare($query7);
        $pdostmt7->bindValue(':id',$id, PDO::PARAM_INT);
        $pdostmt7->execute();
        $detailss = $pdostmt7->fetchAll(PDO::FETCH_OBJ);
        return $detailss;
    }

}