<template>
  <div>

    <el-button type="primary" size="small" @click="dialogFormAddVisible = true">添加代理账号</el-button>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="id" align="center"/>
      <el-table-column min-width="10%" prop="tag" label="代理账号" align="center"/>
      <el-table-column min-width="10%" prop="tag" label="可访问域名" align="center"/>
      <el-table-column min-width="10%" prop="tag" label="状态" align="center"/>
      <el-table-column min-width="10%" prop="isBlack" label="操作" align="center">
        <template slot-scope="scope2">
          <el-button size="mini" type="danger" @click="xx">保存</el-button>
        </template>
      </el-table-column>

    </el-table>

    <!-- dialogAdd 添加代理账号 -->
    <el-dialog :visible.sync="dialogFormAddVisible" title="添加代理账号">
      <el-form :model="dialogFormAdd">

        <el-form-item
          :label-width="dialogLabelWidth"
          label="账号:"
          prop="account"
        >
          <el-input v-model="dialogFormAdd.account" autocomplete="off" placeholder="请输入代理账号" />
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          label="密码:"
          prop="pass"
        >
          <el-input v-model="dialogFormAdd.pass" autocomplete="off" placeholder="请输入密码"/>
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          label="再次确认:"
          prop="passAgain"
        >
          <el-input v-model="dialogFormAdd.passAgain" autocomplete="off" placeholder="请再次输入密码"/>
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          label="可访问域名:"
          prop="domain"
        >
          <el-input :rows="2" v-model="dialogFormAdd.domain" type="textarea" autocomplete="off" placeholder="域名用英文逗号隔开"/>
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          label="状态"
          prop="status"
        >
          <el-radio v-model="dialogFormAdd.radioStatus" label="1">开启</el-radio>
          <el-radio v-model="dialogFormAdd.radioStatus" label="2">关闭</el-radio>
        </el-form-item>

        <el-form-item label="可查看渠道">
          <el-select v-model="dialogFormAdd.selectX1">
            <el-option
              :v-for="item in dialogFormAdd.optionsX1"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item label="可查看统计">
          <el-select v-model="dialogFormAdd.selectX2">
            <el-option
              :v-for="item in dialogFormAdd.optionsX2"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item align="center">
          <el-button @click="dialogFormAddVisible = false">取 消</el-button>
          <el-button type="primary" @click="handleAdd()">确 定</el-button>
        </el-form-item>

      </el-form>
    </el-dialog>

  </div>
</template>

<script>
import { updateDetail } from '@/api/member'

export default {
  data() {
    return {

      form1: {
      },

      tableData: [{
        id: 1
      }],

      dialogLabelWidth: '200px',
      dialogFormAddVisible: false,
      dialogFormAdd: {
        account: '',
        pass: '',
        passAgain: '',
        domain: '',
        radioStatus: '1',

        selectX1: -1,
        optionsX1: [{
          label: '全部',
          value: -1
        }],

        selectX2: -1,
        optionsX2: [{
          label: '全部',
          value: -1
        }]
      },

      // 分页
      currentPage: 1
    }
  },

  created() {
  },

  methods: {
    handleSave() {
      const userId = this.form1.id
      const realName = this.form1.userIDCardName
      const mobileNumber = this.form1.mobile_number
      const aliPayAccount = this.form1.alipay_account

      updateDetail(userId, realName, mobileNumber, aliPayAccount).then(response => {
        if (response.code === 0) {
          this.$notify({
            title: '保存成功',
            message: '',
            type: 'success'
          })
        } else {
          this.$notify({
            title: '保存失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    }
  }
}
</script>

