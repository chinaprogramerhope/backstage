<template>
  <div>
    <!-- 表单 -->
    <el-form :inline="true" :model="form1" style="margin-top: 20px;" align="right">
      <el-form-item label="账号:">
        <el-input v-model="form1.account" placeholder=""/>
      </el-form-item>

      <el-form-item>
        <el-button type="primary" icon="el-icon-search" @click="onSubmit">搜索</el-button>
      </el-form-item>

      <el-form-item>
        <el-button @click="dialogForm1Visible = true">+ 添加</el-button>
      </el-form-item>
    </el-form>

    <!-- table -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      style="width: 100%; margin-bottom: 24px">
      <el-table-column prop="id" label="序号" align="center"/>
      <el-table-column prop="account" label="账号" align="center"/>
      <el-table-column prop="realName" label="真实姓名" align="center"/>
      <el-table-column prop="status" label="状态" align="center"/>
      <el-table-column prop="registerDate" label="注册日期" align="center"/>
      <el-table-column prop="operation" label="操作" align="center">
        <template slot-scope="scope">
          <el-button type="primary" size="mini" @click="dialogForm2Visible = true">编辑</el-button>
          <el-button type="danger" size="mini" @click="handleEnable()">禁用</el-button>
        </template>
      </el-table-column>
    </el-table>

    <!-- 分页 -->
    <el-pagination
      :current-page="currentPage"
      :page-sizes="[10, 20, 30, 40]"
      :page-size="10"
      :total="40"
      layout="total, sizes, prev, pager, next, jumper"
      align="center"
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
    />

    <!-- dialog1 添加 -->
    <el-dialog :visible.sync="dialogForm1Visible" title="添加子账号" center>
      <el-form ref="ruleForm1" :model="ruleForm1" :rules="rules1">

        <el-form-item :label-width="form1LabelWidth" label="子账号:" prop="subAccount">
          <el-input v-model="ruleForm1.subAccount" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="form1LabelWidth" label="密码:" prop="pass">
          <el-input v-model="ruleForm1.pass" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="form1LabelWidth" label="真实姓名:" prop="realName">
          <el-input v-model="ruleForm1.realName" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="form1LabelWidth" label="手机号码:" prop="mobileNumber">
          <el-input v-model="ruleForm1.mobileNumber" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="form1LabelWidth" label="QQ号码:" prop="qq">
          <el-input v-model="ruleForm1.qq" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="form1LabelWidth" label="微信号码:" prop="wechat">
          <el-input v-model="ruleForm1.wechat" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="form1LabelWidth" label="用户角色" prop="selectRole">
          <el-select v-model="ruleForm1.selectRole" placeholder="">
            <el-option
              v-for="item in ruleForm1.optionsRole"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item :label-width="form1LabelWidth" label="状态" prop="selectStatus">
          <el-select v-model="ruleForm1.selectStatus" placeholder="">
            <el-option
              v-for="item in ruleForm1.optionsStatus"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item>
          <el-button @click="dialogForm1Visible = false">取 消</el-button>
          <el-button type="primary" @click="submitRuleForm('ruleForm1')">保 存</el-button>
        </el-form-item>
      </el-form>

    </el-dialog>

    <!-- dialog2 编辑 -->
    <el-dialog :visible.sync="dialogForm2Visible" title="添加子账号" center>
      <el-form ref="ruleForm2" :model="ruleForm2" :rules="rules1">

        <el-form-item :label-width="form2LabelWidth" label="子账号:" prop="subAccount">
          <el-input v-model="ruleForm2.subAccount" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="form2LabelWidth" label="密码:" prop="pass">
          <el-input v-model="ruleForm2.pass" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="form2LabelWidth" label="真实姓名:" prop="realName">
          <el-input v-model="ruleForm2.realName" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="form2LabelWidth" label="手机号码:" prop="mobileNumber">
          <el-input v-model="ruleForm2.mobileNumber" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="form2LabelWidth" label="QQ号码:" prop="qq">
          <el-input v-model="ruleForm2.qq" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="form2LabelWidth" label="微信号码:" prop="wechat">
          <el-input v-model="ruleForm2.wechat" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="form2LabelWidth" label="用户角色" prop="selectRole">
          <el-select v-model="ruleForm2.selectRole" placeholder="">
            <el-option
              v-for="item in ruleForm2.optionsRole"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item :label-width="form2LabelWidth" label="状态" prop="selectStatus">
          <el-select v-model="ruleForm2.selectStatus" placeholder="">
            <el-option
              v-for="item in ruleForm2.optionsStatus"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item>
          <el-button @click="dialogForm2Visible = false">取 消</el-button>
          <el-button type="primary" @click="submitRuleForm('ruleForm2')">保 存</el-button>
        </el-form-item>
      </el-form>

    </el-dialog>

  </div>
</template>

<script>

export default {
  data() {
    return {
      form1: {
        account: ''
      },

      // tableData
      tableData: [{
        id: '2018-11-11 11:11:11',
        timeEnd: '2018-11-11 11:11:11',
        vipAccount: 'ok1',
        gameName: '牛牛1',
        gameRoom: '初级房',
        bet: 11.11,
        winAmount: 11.11,
        winLose: 11.11,
        tax: 11.11
      }, {
        timeBegin: '2018-11-11 11:11:12',
        timeEnd: '2018-11-11 11:11:12',
        vipAccount: 'ok2',
        gameName: '牛牛2',
        gameRoom: '初级房',
        bet: 11.12,
        winAmount: 11.12,
        winLose: 11.12,
        tax: 11.12
      }],

      // 分页
      currentPage: 4,

      // dialog1 添加
      dialogForm1Visible: false,
      ruleForm1: {
        subAccount: '',
        pass: '',
        realName: '',
        mobileNumber: '',
        qq: '',
        webchat: '',
        selectRole: '',
        selectStatus: '正常',
        optionsRole: [{
          label: '客服',
          value: 'customer'
        }],
        optionsStatus: [{
          label: '正常',
          value: 'normal'
        }, {
          label: '冻结',
          value: 'frozen'
        }]
      },
      rules1: {
        subAccount: [
          { required: true, message: '子账号不能为空', trigger: 'blur' }
        ],
        pass: [
          { required: true, message: '请输入密码', trigger: 'blur' }
        ],
        selectRole: [
          { required: true, message: '角色不能为空', trigger: 'change' }
        ]
      },

      form1LabelWidth: '120px',

      // dialog2 编辑
      dialogForm2Visible: false,
      ruleForm2: {
        subAccount: '',
        pass: '',
        realName: '',
        mobileNumber: '',
        qq: '',
        webchat: '',
        selectRole: '',
        selectStatus: '正常',
        optionsRole: [{
          label: '客服',
          value: 'customer'
        }],
        optionsStatus: [{
          label: '正常',
          value: 'normal'
        }, {
          label: '冻结',
          value: 'frozen'
        }]
      },
      form2LabelWidth: '120px'
    }
  },
  methods: {
    obSubmit() {
      console.log('submit!')
    },

    // 分页
    handleSizeChange(val) {
    },
    handleCurrentChange(val) {
    },

    // dialog
    submitRuleForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          alert('submit!')
        } else {
          this.$notify({
            title: '检验不通过, 请检查错误提示',
            message: '',
            type: 'warning'
          })
        }
      })
    }
  }
}
</script>
