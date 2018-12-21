<template>
  <div>

    <el-row align="left" style="margin-top: 30px">
      <el-button type="primary" @click="dialogForm1Visible = true">添加</el-button>
    </el-row>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      style="width: 100%; margin-bottom: 24px"
      stripe="true"
    >
      <el-table-column prop="labelName" label="标签名称" align="center"/>
      <el-table-column prop="sort" label="排序" align="center"/>
      <el-table-column prop="personNum" label="人数" align="center"/>
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

    <!-- dialog1 添加 -->
    <el-dialog :visible.sync="dialogForm1Visible" title="添加标签">
      <el-form :model="form1">

        <el-form-item
          :label-width="form1.form1LabelWidth"
          :rules="[
            { required: true, message: '请输入标签名称', trigger: 'blur' }
          ]"
          label="标签名称:"
          prop="labelName"
        >
          <el-input v-model="form1.labelName" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="form1.form1LabelWidth" label="自动出款:">
          <el-select v-model="form1.selectAutoPayOut" placeholder="">
            <el-option
              v-for="item in form1.optionsAutoPayOut"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item
          :label-width="form1.form1LabelWidth"
          :rules="[
            { required: true, message: '请输入排序值', trigger: 'blur' }
          ]"
          label="排序:"
          prop="sort"
        >
          <el-input v-model="form1.sort" autocomplete="off"/>
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
        labelName: '2018-11-11 11:11:11',
        timeEnd: '2018-11-11 11:11:11',
        vipAccount: 'ok1',
        gameName: '牛牛1'
      }, {
        labelName: '2018-11-11 11:11:12',
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
