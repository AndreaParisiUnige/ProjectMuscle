<div class="comments-section">
  <h2>Commenti degli Utenti</h2>
  <div class="comments-container">

    <?php 
    $comments = genericSelect("commenti", ['*'], "articolo=?", [$_GET['id']], $con);
    if(isset($comments)){
        if (is_array($comments) && !is_array($comments[0])) {   // Caso in cui la select ha restituito un singolo elemento
            $comments = [$comments]; 
        }
        foreach ($comments as $comment) {
            echo 
                "<div class=\"comment\">
                <p class=\"comment-author\">" . $comment['utente'] . "</p>
                <p class=\"comment-date\">" . $comment['data_inserimento'] . "</p>
                <p class=\"comment-body\">" . $comment['testo'] . "</p>" . 
                "</div>";
        }
    } 
    ?>
  </div>

  <div class="comment-form">
    <h3>Lascia un commento</h3>
    <form id="commentForm" action="../article/addComment.php" method="post">
        <textarea id="comment" name="comment" placeholder="Scrivi un commento..." required></textarea>
        <input hidden type="text" id="article" name="article" value="<?php echo $_GET['id']; ?>">
        <input hidden type="text" id="user" name="user" value="<?php if (isset($_SESSION['email'])) echo $_SESSION['email']; ?>">
        <button type="submit" id="submit_button">Invia</button>
    </form>
  </div>
</div>
