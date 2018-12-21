<template>
  <div>

    <el-row align="left" style="margin-top: 30px">
      <el-button type="primary" @click="dialogForm1Visible = true">+ 新增等级</el-button>
    </el-row>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'lvName', order:'descending'}"
      style="width: 100%; margin-bottom: 24px"
      stripe="true"
    >
      <el-table-column prop="lvName" label="等级名称" align="center"/>
      <el-table-column prop="incrCondition" label="晋升条件" align="center"/>
      <el-table-column prop="vipNum" label="会员数" align="center"/>
      <el-table-column prop="operation" label="操作" align="center"/>
    </el-table>

    <!-- 分页 -->
    <el-pagination
      :current-page="currentPage"
      :page-sizes="[10, 20, 30, 40]"
      :page-size="10"
      :total="40"
      align="center"
      layout="total, sizes, prev, pager, next, jumper"
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
    />

    <!-- dialog1 新增等级 -->
    <el-dialog :visible.sync="dialogForm1Visible" title="添加新的会员等级">
      <el-form :model="form1">

        <el-form-item
          :label-width="form1.form1LabelWidth"
          :rules="[
            { required: true, message: '请输入等级名称', trigger: 'blur' }
          ]"
          label="等级名称:"
          prop="lvName"
        >
          <el-input v-model="form1.lvName" autocomplete="off"/>
        </el-form-item>

        <el-form-item
          :label-width="form1.form1LabelWidth"
          :rules="[
            { required: true, message: '请输入等级名称', trigger: 'blur' }
          ]"
          label="晋升条件:"
          prop="incrCondition"
        >
          <el-input v-model="form1.incrCondition" autocomplete="off" placeholder="请输入金额">
            <theme slot="prepend">￥</theme>
          </el-input>
        </el-form-item>

        <el-form-item
          :label-width="form1.form1LabelWidth"
          label="备注:"
        >
          <el-input v-model="form1.sort" :rows="2" type="textarea" autocomplete="off"/>
        </el-form-item>

        <el-form-item align="center">
          <el-button @click="dialogForm1Visible = false">取 消</el-button>
          <el-button type="primary" @click="submitRuleForm('form1')">确 定</el-button>
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
        form1LabelWidth: '120px',
        labelName: '',
        selectAutoPayOut: '是',
        sort: '',
        optionsAutoPayOut: [{
          label: '是',
          value: 'yes'
        }, {
          label: '否',
          value: 'no'
        }]
      },
      dialogForm1Visible: false,

      // tableData
      tableData: [{
        lvName: '2018-11-11 11:11:11',
        timeEnd: '2018-11-11 11:11:11',
        vipAccount: 'ok1',
        gameName: '牛牛1'
      }, {
        lvName: '2018-11-11 11:11:12',
        timeEnd: '2018-11-11 11:11:12',
        vipAccount: 'ok2',
        gameName: '牛牛2'
      }],

      // 分页
      currentPage: 4
    }
  },
  methods: {
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
