<br />
<br />
<br />
<br />
<table class="table">
    <thead>
        <tr>
            <th scope="col">Grade</th>
            <th scope="col">Curriculum</th>
            <th scope="col">Subject</th>
            <th scope="col">Chapter</th>
            <th scope="col">Document</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $all_documents = db_get_all_documents();
        foreach ($all_documents as $document) {
        ?>
            <tr>
                <td><?php print $document['grade']; ?></td>
                <td><?php print $document['curriculum']; ?></td>
                <td><?php print $document['subject']; ?></td>
                <td><?php print $document['chapter']; ?></td>
                <td><?php print $document['document']; ?></td>
            </tr>
        <?php
        }

        ?>
    </tbody>
</table>