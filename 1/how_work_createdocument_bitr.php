<?
//------ Initialization
arProperties = array(
            'Title' => '',
            'TemplateId' => null,
            'ListId' => null,
            //'FieldDealId' => null,
            'ElementsId' => null,
            //'ElementsIdText' => null,
            'FieldsList_1' => null,
            'FieldsList_2' => null,
            'FieldsList_3' => null,
            'FieldsList_4' => null,
            'FieldsList_5' => null,
            'FieldsList_6' => null,
            'TitleList_1' => '',
            'TitleList_2' => '',
            'TitleList_3' => '',
            'TitleList_4' => '',
            'TitleList_5' => '',
            'TitleList_6' => '',
            'FieldsSum_1' => '',
            'FieldsSum_2' => '',
            'FieldsSum_3' => '',
            'FieldsSum_4' => '',
            //return
            'DocumentId' => null,
            'DocumentUrl' => null,
            'DocumentPdf' => null,
            'DocumentDocx' => null,
            'DocumentNumber' => null,
            'DocumentObject' => null,
            
        );

$this->SetPropertiesTypes([
            'DocumentId' => ['Type' => 'int'],
            'DocumentUrl' => ['Type' => 'string'],
            'DocumentPdf' => ['Type' => 'file'],
            'DocumentDocx' => ['Type' => 'file'],
            'DocumentNumber' => ['Type' => 'string'],
            'DocumentObject' => ['Type' => 'int'],
        ]);

//------------------------------


        list($entityTypeName, $entityId) = explode('_', $this->GetDocumentId()[2]);
        $entityTypeId = \CCrmOwnerType::ResolveID($entityTypeName);
        $providerClassName = static::getDataProviderByEntityTypeId($entityTypeId);
        $templateId = $this->TemplateId;
        $template = DocumentGenerator\Template::loadById($templateId);
        // создаем по выбранному шаблону
        $template->setSourceType($providerClassName);
        $document = \Bitrix\DocumentGenerator\Document::createByTemplate($template, $entityId);
        // создаем массив для подстановки в шаблон значений
        $this->WriteToTrackingService(print_r($this->ElementsId, true));
        $this->WriteToTrackingService(print_r($this->ElementsIdText, true));
        $iblockId = intval($this->ListId);
        $elementsId = $el = $this->ElementsId;

        $FieldsSum_1 = $this->FieldsSum_1;
        $FieldsSum_2 = $this->FieldsSum_2;
        $FieldsSum_3 = $this->FieldsSum_3;
        $FieldsSum_4 = $this->FieldsSum_4;
        $TitleList_1 = $this->TitleList_1;
        $TitleList_2 = $this->TitleList_2;
        $TitleList_3 = $this->TitleList_3;
        $TitleList_4 = $this->TitleList_4;
        $TitleList_5 = $this->TitleList_5;
        $TitleList_6 = $this->TitleList_6;
        
        if ($this->FieldsList_1) $arSelect[] = $this->FieldsList_1;
        if ($this->FieldsList_2) $arSelect[] = $this->FieldsList_2;
        if ($this->FieldsList_3) $arSelect[] = $this->FieldsList_3;
        if ($this->FieldsList_4) $arSelect[] = $this->FieldsList_4;
        if ($this->FieldsList_5) $arSelect[] = $this->FieldsList_5;
        if ($this->FieldsList_6) $arSelect[] = $this->FieldsList_6;

        $arFilter = [
            'IBLOCK_ID' => $iblockId,
            'ID' => $el,
            'ACTIVE'=>'Y'
        ];

        $res = CIBlockElement::GetList([], $arFilter, false, [], $arSelect);
        while($arRes = $res->GetNext())
        {
            $values[] = $arRes;
        }

        $arTemplateFields = [
            0 => 'Field1',
            1 => 'Field2',
            2 => 'Field3',
            3 => 'Field4',
            4 => 'Field5',
            5 => 'Field6',
        ];
        foreach ($values as $key => $element) {
            
            foreach ($element as $field => $value) {
                if ((strpos($field, 'ID') !== false) || (strpos($field, '~') !== false) ){
                    continue;
                }
                    $cleanElements[$key][$field] = $value;
            }
            
        }
        $arheader = array_keys($cleanElements[0]);
        foreach ($arheader as $key => $val) {
            if ((strpos($val, 'ID') !== false) || (strpos($val, '~') !== false) ){
                continue;
            } else {
                $arheaders[$arTemplateFields[$key]] = $val;
            }
        }

        foreach ($cleanElements as $el => $elem) {
            foreach ($elem as $key => $val) {
                if ($val['TYPE'] == 'HTML') $val = htmlspecialchars_decode($val['TEXT']);
                $arElements[$el][array_flip($arheaders)[$key]] = $val;
            }
        }
        //получим ссылку на файл
        foreach ($arElements as &$element) {
            foreach ($element as $k => &$el) {
                if ($k == 'Field1') {
                    $filepath = CFile::GetPath($el);
                    $el = $filepath;
                }
            }
            unset ($el);
        }
        unset ($element);
        
        $documentValues = [];
