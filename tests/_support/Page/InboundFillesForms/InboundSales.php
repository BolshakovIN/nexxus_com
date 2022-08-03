<?php

namespace Page\InboundFillesForms;
use AcceptanceTester;

class InboundSales
{
    public function __construct(AcceptanceTester $tester)
    {
        $this -> tester = $tester;
    }
    public function aploadFile()
    {
        $I = $this -> tester;
        $I -> clickWithLeftButton('//*[@id="inboundSalesFilesTab"]/div/div[1]/form/div[1]/div[1]/div[1]/button[1]/span');
        $I -> waitForElementClickable('[name="clientId"]');
        $I -> click('[name="clientId"]');
        $I -> fillField('[name="clientId"]', 'CEFCO');
        $I -> waitForElementClickable('body > div.el-select-dropdown.el-popper > div.el-scrollbar > div.el-select-dropdown__wrap.el-scrollbar__wrap > ul > li:nth-child(1) > span');
        $I -> click('body > div.el-select-dropdown.el-popper > div.el-scrollbar > div.el-select-dropdown__wrap.el-scrollbar__wrap > ul > li:nth-child(1) > span');
       // $I -> attachFile('.upload__text','CEFCO_propane_test (9).xlsx');
        $I->sendPost('https://clm.qa.nexxus.site/api/diofile/inbound/upload', [], ['file'=>[

        ]

        ]);
    }
}